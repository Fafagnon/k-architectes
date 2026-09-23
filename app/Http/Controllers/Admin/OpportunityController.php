<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OpportunityController extends Controller
{
    public function index(): View
    {
        $opportunities = Opportunity::latest('created_at')->paginate(10);
        return view('admin.opportunites.index', compact('opportunities'));
    }

    public function create(): View
    {
        return view('admin.opportunites.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:opportunities,slug'],
            'contract_type' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:150'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'application_deadline' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['draft', 'published', 'closed'])],
        ], [
            'title.required' => 'L’intitulé du poste est obligatoire.',
            'contract_type.required' => 'Le type de contrat est obligatoire.',
            'location.required' => 'Le lieu est obligatoire.',
            'excerpt.required' => 'Le résumé est obligatoire.',
            'excerpt.max' => 'Le résumé ne doit pas dépasser 500 caractères.',
            'body.required' => 'La description du poste est obligatoire.',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Opportunity::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $publishedAt = $validated['status'] !== 'draft' ? now() : null;

        Opportunity::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'contract_type' => $validated['contract_type'],
            'location' => $validated['location'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'application_deadline' => $validated['application_deadline'] ?? null,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.opportunites.index')
            ->with('succes', 'L’opportunité a été créée avec succès.');
    }

    public function edit(Opportunity $opportunity): View
    {
        return view('admin.opportunites.edit', compact('opportunity'));
    }

    public function update(Request $request, Opportunity $opportunity): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('opportunities', 'slug')->ignore($opportunity->id)],
            'contract_type' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:150'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'application_deadline' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['draft', 'published', 'closed'])],
        ], [
            'title.required' => 'L’intitulé du poste est obligatoire.',
            'contract_type.required' => 'Le type de contrat est obligatoire.',
            'location.required' => 'Le lieu est obligatoire.',
            'excerpt.required' => 'Le résumé est obligatoire.',
            'excerpt.max' => 'Le résumé ne doit pas dépasser 500 caractères.',
            'body.required' => 'La description du poste est obligatoire.',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Opportunity::where('slug', $slug)->where('id', '!=', $opportunity->id)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $publishedAt = $opportunity->published_at;
        if ($validated['status'] !== 'draft' && empty($publishedAt)) {
            $publishedAt = now();
        }

        $opportunity->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'contract_type' => $validated['contract_type'],
            'location' => $validated['location'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'application_deadline' => $validated['application_deadline'] ?? null,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.opportunites.index')
            ->with('succes', 'L’opportunité a été mise à jour.');
    }

    public function destroy(Opportunity $opportunity): RedirectResponse
    {
        $opportunity->delete();

        return redirect()->route('admin.opportunites.index')
            ->with('succes', 'L’opportunité a été supprimée.');
    }
}
