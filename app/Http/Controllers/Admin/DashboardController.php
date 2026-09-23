<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\JobApplication;
use App\Models\Opportunity;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'total_opportunities' => Opportunity::count(),
            'open_opportunities' => Opportunity::open()->count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            'total_messages' => ContactMessage::count(),
            'unread_applications' => JobApplication::where('status', 'unread')->count(),
            'total_applications' => JobApplication::count(),
        ];

        $recentArticles = Article::latest()->take(5)->get();
        $recentOpportunities = Opportunity::latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentApplications = JobApplication::with('opportunity')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentOpportunities', 'recentMessages', 'recentApplications'));
    }
}
