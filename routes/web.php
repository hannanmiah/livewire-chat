<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Components\TestComponent;
use App\Livewire\Pages\Chat;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Home::class)->middleware('auth')->name('home');

Route::middleware('auth')->prefix('chats')->group(function () {
    Route::get('/', Home::class)->name('chats.index');
    Route::get('/{chat}', Chat::class)->name('chats.view');
});

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('test', TestComponent::class)->name('test');

require __DIR__ . '/auth.php';
