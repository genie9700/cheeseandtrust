<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;

 Route::redirect('/', '/login');

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

   Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
    
    volt::route('dashboard', 'user.dashboard')->name('dashboard');
    volt::route('deposit', 'user.deposit')->name('deposit');
    volt::route('subscribe', 'user.subscribe')->name('subscribe');
    volt::route('profile', 'user.profile')->name('profile');
    volt::route('verify', 'user.verify')->name('verify');
    volt::route('copy', 'user.copy')->name('copy');
    volt::route('trades', 'user.trades')->name('trades');
    volt::route('withdraw', 'user.withdraw')->name('withdraw');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';