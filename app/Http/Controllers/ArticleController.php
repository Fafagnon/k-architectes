<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::published()
            ->latest('published_at')
            ->paginate(6);

        return view('pages.actualites', compact('articles'));
    }

    public function show(Article $article): View
    {
        // Allow authenticated admin to preview unpublished articles
        if ($article->status !== 'published' || !$article->published_at || $article->published_at->isFuture()) {
            if (!auth()->check()) {
                abort(404);
            }
        }

        return view('pages.article-detail', compact('article'));
    }
}
