<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    public function index(): View
    {
        $applications = JobApplication::with('opportunity')
            ->orderByRaw("status = 'unread' DESC")
            ->latest('created_at')
            ->paginate(15);

        return view('admin.candidatures.index', compact('applications'));
    }

    public function show(JobApplication $application): View
    {
        return view('admin.candidatures.show', compact('application'));
    }

    public function download(JobApplication $application): \Symfony\Component\HttpFoundation\StreamedResponse|RedirectResponse
    {
        if (!$application->cv_path || !Storage::disk('public')->exists($application->cv_path)) {
            return back()->with('erreur', 'Le fichier du CV est introuvable sur le serveur.');
        }

        $extension = pathinfo($application->cv_path, PATHINFO_EXTENSION);
        $safeName = \Illuminate\Support\Str::slug($application->nom_complet);
        $filename = 'CV_' . ($safeName ?: 'candidat') . ($extension ? '.' . $extension : '.pdf');

        return Storage::disk('public')->download($application->cv_path, $filename);
    }

    public function updateStatus(Request $request, JobApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['unread', 'reviewed', 'contacted', 'rejected'])],
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('succes', 'Le statut de la candidature a été mis à jour.');
    }

    public function destroy(JobApplication $application): RedirectResponse
    {
        if ($application->cv_path) {
            Storage::disk('public')->delete($application->cv_path);
        }

        $application->delete();

        return redirect()->route('admin.candidatures.index')
            ->with('succes', 'La candidature a été supprimée.');
    }
}
