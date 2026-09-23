<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $articles = Article::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.home', compact('articles'));
    }
}
