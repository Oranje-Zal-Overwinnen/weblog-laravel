<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WeblogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WeblogController::class, 'index'])->name('weblogs.index');

Route::get('/weblogs/create', [WeblogController::class, 'create'])
    ->middleware('auth')
    ->name('weblogs.create');

Route::post('/weblogs', [WeblogController::class, 'store'])
    ->middleware('auth')
    ->name('weblogs.store');

Route::get('/weblogs/{weblog}', [WeblogController::class, 'show'])->name('weblogs.show');

Route::post('/weblogs/{weblog}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

Route::get('/premium', PremiumController::class)->name('premium.index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/weblogs/{weblog}/edit', [WeblogController::class, 'edit'])->name('weblogs.edit');

    Route::put('/weblogs/{weblog}', [WeblogController::class, 'update'])->name('weblogs.update');

    Route::patch('/weblogs/{weblog}/premium', [WeblogController::class, 'updatePremium'])
        ->name('weblogs.premium');

    Route::delete('/weblogs/{weblog}', [WeblogController::class, 'destroy'])->name('weblogs.destroy');

    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::post('/subscription', [SubscriptionController::class, 'store'])
        ->name('subscription.store');

    Route::delete('/subscription', [SubscriptionController::class, 'destroy'])
        ->name('subscription.destroy');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('register.store');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
});
