<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::latest('created_at')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.articles.create');
    }

    public function store(Request $request, ImageService $imageService): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:articles,slug'],
            'tag' => ['required', 'string', 'max:100'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'reading_minutes' => ['nullable', 'integer', 'min:1', 'max:120'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'image', 'max:20480', 'mimes:jpg,jpeg,png,webp'],
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'tag.required' => 'Le tag/catégorie est obligatoire.',
            'excerpt.required' => 'Le résumé/chapeau est obligatoire.',
            'excerpt.max' => 'Le résumé ne doit pas dépasser 500 caractères.',
            'body.required' => 'Le corps de l’article est obligatoire.',
            'cover_image.max' => 'L’image de couverture ne doit pas dépasser 20 Mo.',
            'cover_image.mimes' => 'Format accepté : JPG, JPEG, PNG, WEBP.',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $imageService->processCoverImage($request->file('cover_image'), 'articles');
        }

        $publishedAt = $validated['published_at'] ?? null;
        if ($validated['status'] === 'published' && empty($publishedAt)) {
            $publishedAt = now();
        }

        Article::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'tag' => $validated['tag'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'reading_minutes' => $validated['reading_minutes'] ?? null,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
            'cover_image' => $coverImagePath,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('succes', 'L’article a été créé avec succès.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article, ImageService $imageService): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('articles', 'slug')->ignore($article->id)],
            'tag' => ['required', 'string', 'max:100'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'reading_minutes' => ['nullable', 'integer', 'min:1', 'max:120'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
            'cover_image' => ['nullable', 'image', 'max:20480', 'mimes:jpg,jpeg,png,webp'],
            'supprimer_image' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'tag.required' => 'Le tag/catégorie est obligatoire.',
            'excerpt.required' => 'Le résumé/chapeau est obligatoire.',
            'excerpt.max' => 'Le résumé ne doit pas dépasser 500 caractères.',
            'body.required' => 'Le corps de l’article est obligatoire.',
            'cover_image.max' => 'L’image de couverture ne doit pas dépasser 20 Mo.',
            'cover_image.mimes' => 'Format accepté : JPG, JPEG, PNG, WEBP.',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $coverImagePath = $article->cover_image;

        if ($request->boolean('supprimer_image')) {
            if ($coverImagePath && !str_starts_with($coverImagePath, 'assets/')) {
                Storage::disk('public')->delete($coverImagePath);
            }
            $coverImagePath = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($coverImagePath && !str_starts_with($coverImagePath, 'assets/')) {
                Storage::disk('public')->delete($coverImagePath);
            }
            $coverImagePath = $imageService->processCoverImage($request->file('cover_image'), 'articles');
        }

        $publishedAt = $validated['published_at'] ?? null;
        if ($validated['status'] === 'published' && empty($publishedAt)) {
            $publishedAt = $article->published_at ?? now();
        }

        $article->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'tag' => $validated['tag'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'reading_minutes' => $validated['reading_minutes'] ?? null,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
            'cover_image' => $coverImagePath,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('succes', 'L’article a été mis à jour avec succès.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->cover_image && !str_starts_with($article->cover_image, 'assets/')) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('succes', 'L’article a été supprimé.');
    }
}
