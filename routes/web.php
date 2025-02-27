<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Redirect guests to login page
Route::redirect('/', '/login')->name('root');

// Home route for authenticated users
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Posts routes
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::get('/posts/{post}/check-like', [PostController::class, 'checkLike'])->name('posts.checkLike');

    // Skills routes
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::delete('/skills/{skill}/remove', [SkillController::class, 'remove'])->name('skills.remove');

    // Languages routes
    Route::post('/languages', [LanguageController::class, 'store'])->name('languages.store');
    Route::delete('/languages/{language}/remove', [LanguageController::class, 'remove'])->name('languages.remove');

    // Projects routes
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('/projects/{project}/remove', [ProjectController::class, 'remove'])->name('projects.remove');

    // Certificates routes
    Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::delete('/certificates/{certificate}/remove', [CertificateController::class, 'remove'])->name('certificates.remove');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';