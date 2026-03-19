<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\VerificationController;

Auth::routes();

Route::middleware('guest')
    ->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    });

Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');
        Route::get('video', [HomeController::class, 'video_list'])->name('home.video_list');
        Route::get('video/{video:slug}', [HomeController::class, 'video_item'])->name('home.video_item');

        Route::name('profile.')
            ->prefix('profile')
            ->group(function () {
                Route::get('', [ProfileController::class, 'index'])->name('index');
                Route::post('/update_info', [ProfileController::class, 'update_info'])->name('update_info');
                Route::post('/update_password', [ProfileController::class, 'update_password'])->name('update_pswd');
                Route::post('/remove', [ProfileController::class, 'remove'])->name('remove');
        });

        Route::name('article.')
            ->prefix('article')
            ->group(function () {
                Route::get('', [ArticleController::class, 'index'])->name('index');
                Route::get('/{article:slug}', [ArticleController::class, 'show'])->name('show');
            });
    });
