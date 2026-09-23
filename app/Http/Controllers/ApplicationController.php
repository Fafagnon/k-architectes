<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Opportunity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function create(Request $request): View
    {
        $openOpportunities = Opportunity::open()->orderBy('title')->get();
        $selectedSlug = $request->query('poste');

        return view('pages.postuler', compact('openOpportunities', 'selectedSlug'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        // Anti-spam honeypot
        if ($request->filled('_honey')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('postuler.create', ['envoye' => 1]);
        }

        $validated = $request->validate([
            'Nom' => ['required', 'string', 'max:100'],
            'Prenom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'Telephone' => ['required', 'string', 'max:50'],
            'Poste_vise' => ['required', 'string', 'max:150'],
            'attachment' => ['required', 'file', 'max:20480', 'mimes:pdf,doc,docx'],
            'Message' => ['required', 'string', 'max:10000'],
        ], [
            'Nom.required' => 'Indiquez votre nom.',
            'Prenom.required' => 'Indiquez votre prénom.',
            'email.required' => 'Indiquez votre adresse e-mail.',
            'email.email' => 'Cette adresse e-mail semble incomplète.',
            'Telephone.required' => 'Indiquez votre numéro de téléphone.',
            'Poste_vise.required' => 'Sélectionnez le poste visé.',
            'attachment.required' => 'Veuillez joindre votre CV (PDF, DOC ou DOCX).',
            'attachment.max' => 'Le CV ne doit pas dépasser 20 Mo.',
            'Message.required' => 'Rédigez votre message ou lettre de motivation.',
        ]);

        $cvPath = $request->file('attachment')->store('candidatures', 'public');

        // Associer à une opportunité si possible
        $opportunity = Opportunity::where('title', $validated['Poste_vise'])
            ->orWhere('slug', $validated['Poste_vise'])
            ->first();

        JobApplication::create([
            'nom' => $validated['Nom'],
            'prenom' => $validated['Prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['Telephone'],
            'poste_vise' => $validated['Poste_vise'],
            'opportunity_id' => $opportunity?->id,
            'message' => $validated['Message'],
            'cv_path' => $cvPath,
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('postuler.create', ['envoye' => 1]);
    }
}
