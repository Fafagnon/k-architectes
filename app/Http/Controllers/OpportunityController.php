<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\View\View;

class OpportunityController extends Controller
{
    public function index(): View
    {
        $opportunities = Opportunity::published()
            ->latest('published_at')
            ->get();

        return view('pages.opportunites', compact('opportunities'));
    }

    public function show(Opportunity $opportunity): View
    {
        if ($opportunity->status === 'draft' && !auth()->check()) {
            abort(404);
        }

        return view('pages.opportunite-detail', compact('opportunity'));
    }
}
