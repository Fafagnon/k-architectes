<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobApplicationController as AdminJobApplicationController;
use App\Http\Controllers\Admin\OpportunityController as AdminOpportunityController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/le-cabinet', [PageController::class, 'cabinet'])->name('cabinet');

// Réalisations & Projets
Route::get('/realisations', [ProjectController::class, 'index'])->name('realisations.index');
Route::get('/realisations/{slug}', [ProjectController::class, 'show'])->name('realisations.show');

// Actualités
Route::get('/actualites', [ArticleController::class, 'index'])->name('actualites.index');
Route::get('/actualites/{article:slug}', [ArticleController::class, 'show'])->name('actualites.show');

// Opportunités
Route::get('/opportunites', [OpportunityController::class, 'index'])->name('opportunites.index');
Route::get('/opportunites/{opportunity:slug}', [OpportunityController::class, 'show'])->name('opportunites.show');

// Formulaires Contact & Candidature
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/postuler', [ApplicationController::class, 'create'])->name('postuler.create');
Route::post('/postuler', [ApplicationController::class, 'store'])->name('postuler.submit');

/*
|--------------------------------------------------------------------------
| Redirections 301 pour anciennes URL statiques (.html)
|--------------------------------------------------------------------------
*/
Route::redirect('/index.html', '/', 301);
Route::redirect('/le-cabinet.html', '/le-cabinet', 301);
Route::redirect('/realisations.html', '/realisations', 301);
Route::redirect('/actualites.html', '/actualites', 301);
Route::redirect('/opportunites.html', '/opportunites', 301);
Route::redirect('/contact.html', '/contact', 301);
Route::redirect('/postuler.html', '/postuler', 301);
Route::get('/projet-{file}', [ProjectController::class, 'legacyRedirect'])->where('file', '.*\.html$');

/*
|--------------------------------------------------------------------------
| Authentification Panneau d'Administration
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Espace Administrateur Protégé
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Gestion des Actualités
        Route::resource('articles', AdminArticleController::class)->except(['show']);

        // Gestion des Opportunités
        Route::resource('opportunites', AdminOpportunityController::class)->except(['show']);

        // Messages de Contact
        Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
        Route::get('/messages/{message}/download', [AdminContactMessageController::class, 'download'])->name('messages.download');
        Route::post('/messages/{message}/toggle', [AdminContactMessageController::class, 'toggleStatus'])->name('messages.toggle');
        Route::delete('/messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

        // Candidatures
        Route::get('/candidatures', [AdminJobApplicationController::class, 'index'])->name('candidatures.index');
        Route::get('/candidatures/{application}', [AdminJobApplicationController::class, 'show'])->name('candidatures.show');
        Route::get('/candidatures/{application}/download', [AdminJobApplicationController::class, 'download'])->name('candidatures.download');
        Route::patch('/candidatures/{application}/status', [AdminJobApplicationController::class, 'updateStatus'])->name('candidatures.updateStatus');
        Route::delete('/candidatures/{application}', [AdminJobApplicationController::class, 'destroy'])->name('candidatures.destroy');
    });
});
