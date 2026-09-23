<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function cabinet(): View
    {
        return view('pages.cabinet');
    }
}
