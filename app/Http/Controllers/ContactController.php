<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('pages.contact');
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        // Anti-spam honeypot
        if ($request->filled('_honey')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('contact.create', ['envoye' => 1]);
        }

        $validated = $request->validate([
            'Nom' => ['required', 'string', 'max:100'],
            'Prenom' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:150'],
            'Telephone' => ['nullable', 'string', 'max:50'],
            'Message' => ['required', 'string', 'max:10000'],
            'attachment' => ['nullable', 'file', 'max:20480', 'mimes:pdf,doc,docx,jpg,jpeg,png,webp,dwg'],
        ], [
            'Nom.required' => 'Indiquez votre nom.',
            'Prenom.required' => 'Indiquez votre prénom.',
            'email.email' => 'Cette adresse e-mail semble incomplète.',
            'Message.required' => 'Décrivez brièvement votre projet.',
            'attachment.max' => 'Le fichier ne doit pas dépasser 20 Mo.',
        ]);

        if (empty($validated['email']) && empty($validated['Telephone'])) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Indiquez au moins une adresse e-mail ou un numéro de téléphone.',
                ], 422);
            }
            return back()->withErrors(['Telephone' => 'Indiquez au moins un moyen de contact.'])->withInput();
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('contacts', 'public');
        }

        ContactMessage::create([
            'nom' => $validated['Nom'],
            'prenom' => $validated['Prenom'],
            'email' => $validated['email'] ?? null,
            'telephone' => $validated['Telephone'] ?? null,
            'message' => $validated['Message'],
            'attachment_path' => $attachmentPath,
            'status' => 'unread',
            'ip_address' => $request->ip(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('contact.create', ['envoye' => 1]);
    }
}
