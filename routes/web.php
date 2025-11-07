<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\QuickGoalsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('feed.index');
    }
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/menu', [ProfileController::class, 'menu'])->name('profile.menu');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/theme', [ProfileController::class, 'updateTheme'])->name('profile.updateTheme');
    
    // Feed routes
    Route::get('/feed', [FeedController::class, 'index'])->name('feed.index');
    Route::post('/feed/{activity}/like', [FeedController::class, 'toggleLike'])->name('feed.toggleLike');
    Route::get('/feed/{activity}/likes', [FeedController::class, 'getLikes'])->name('feed.getLikes');
    
    // Social routes
    Route::post('/users/{user}/follow', [SocialController::class, 'follow'])->name('social.follow');
    Route::post('/users/{user}/unfollow', [SocialController::class, 'unfollow'])->name('social.unfollow');
    
    // User routes
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    
    // Challenge routes
    Route::resource('challenges', ChallengeController::class);
    Route::post('/challenges/{challenge}/start', [ChallengeController::class, 'start'])->name('challenges.start');
    Route::post('/challenges/{challenge}/pause', [ChallengeController::class, 'pause'])->name('challenges.pause');
    Route::post('/challenges/{challenge}/resume', [ChallengeController::class, 'resume'])->name('challenges.resume');
    Route::post('/challenges/{challenge}/complete', [ChallengeController::class, 'complete'])->name('challenges.complete');
    
    // Goal tracking routes
    Route::post('/goals/{goal}/toggle', [GoalController::class, 'toggle'])->name('goals.toggle');
    
    // API routes for quick goals
    Route::get('/api/quick-goals', [QuickGoalsController::class, 'index']);
    
    // Admin routes
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/user/{user}', [AdminController::class, 'showUser'])->name('admin.user');
});

require __DIR__.'/auth.php';

