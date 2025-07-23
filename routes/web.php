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
    // Route::redirect('settings', 'settings/profile');

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

Route::middleware(['auth', 'admin'])->group(function () {

   Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
    
    volt::route('admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    volt::route('admin/user', 'admin.user.index')->name('admin.user.index');
    volt::route('admin/users/{user}/edit', 'admin.user.edit')->name('admin.user.edit');
    volt::route('admin/transaction/{user}/show', 'admin.transaction.show')->name('admin.transaction.show');
    
    volt::route('admin/deposit', 'admin.deposit.index')->name('admin.deposit.index');
    volt::route('admin/deposits/{deposit}/edit', 'admin.deposit.edit')->name('admin.deposit.edit');
    
    volt::route('admin/subscription', 'admin.subscription')->name('admin.subscription');
    volt::route('admin/verification', 'admin.verification.index')->name('admin.verify.index');
    volt::route('admin/verifications/{verification}/edit', 'admin.verification.edit')->name('admin.verify.edit');
    volt::route('admin/withdraw', 'admin.withdraw')->name('admin.withdraw');
    volt::route('admin/transaction', 'admin.transaction')->name('admin.transaction');
   

});

require __DIR__.'/auth.php';