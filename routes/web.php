<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\HomeController as AdminController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Guest\HomeController as GuestController;
use Illuminate\Support\Facades\Route;


Route::get('/', [GuestController::class, 'index']);

Route::get('/home', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')
    ->prefix("/admin")
    ->name("admin.")
    ->group(function () {
        Route::resource('projects', ProjectController::class);
    });

    Route::middleware('auth')
    ->prefix("profile") 
    ->name("profile.")
    ->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

require __DIR__.'/auth.php';
