<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\AdminBlogController; // 1. Import the Admin Controller

// Main Homepage Route
Route::get('/', [PublicBlogController::class, 'index'])->name('home');

// Dynamic Blog Detail Page Route
Route::get('/blog/{id}', [PublicBlogController::class, 'show'])->name('blog.show');

// Dashboard Home View
Route::get('/dashboard', [AdminBlogController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// AJAX Filter Route
Route::get('/blogs/filter', [PublicBlogController::class, 'index'])->name('blogs.filter');

// Protected Admin Management Actions
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Notice CRUD Management Routes
    Route::get('/admin/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/admin/blogs', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/admin/blogs/{id}/edit', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/admin/blogs/{id}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/{id}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');
});

require __DIR__.'/auth.php';