<?php

use App\Livewire\Pages\ChatPage;
use App\Livewire\Pages\ChatRoomsPage;
use App\Livewire\Pages\FriendsPage;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/friends', FriendsPage::class)
    ->middleware(['auth', 'verified'])
    ->name('pages.friends');

Route::get('/chat/{friendId?}', ChatPage::class)
    ->middleware(['auth', 'verified'])
    ->name('pages.chat');

Route::get('/rooms/{roomId?}', ChatRoomsPage::class)
    ->middleware(['auth', 'verified'])
    ->name('pages.chat-rooms');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
