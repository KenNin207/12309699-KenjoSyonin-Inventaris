<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminDashboardController;
// use App\Http\Controllers\StaffDashboardController;


// Halaman Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Proses Login & Logout
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk admin
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Items admin
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/items/{id}/lendings', [ItemController::class, 'showLendings'])->name('items.lendings');
    // Route Export Excel
    Route::get('/items/export', [ItemController::class, 'exportExcel'])->name('items.export');

    //Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    // Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Users (Dipisah berdasarkan Role)
    Route::get('/users/admin', [UserController::class, 'adminList'])->name('users.admin');
    Route::get('/users/staff', [UserController::class, 'staffList'])->name('users.staff');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    Route::get('/users/admin/export', [UserController::class, 'exportAdmin'])->name('users.export.admin');
    Route::get('/users/staff/export', [UserController::class, 'exportStaff'])->name('users.export.staff');
});

// Route untuk Staff
Route::middleware(['auth', CheckRole::class . ':staff'])->prefix('staff')->group(function () {

    // Dashboard staff
Route::get('/dashboard', [App\Http\Controllers\StaffDashboardController::class, 'index'])->name('staff.dashboard');

    // Items staff
    Route::get('/items', [ItemController::class, 'staffIndex'])->name('staff.items.index');

    // Fitur Peminjaman staff
    Route::get('/lendings', [LendingController::class, 'index'])->name('lendings.index');
    Route::get('/lendings/create', [LendingController::class, 'create'])->name('lendings.create'); 
    Route::post('/lendings', [LendingController::class, 'store'])->name('lendings.store');
    Route::put('/lendings/{id}/return', [LendingController::class, 'returnItem'])->name('lendings.return');

    // Delete staff
    Route::delete('/lendings/{id}', [LendingController::class, 'destroy'])->name('lendings.destroy');
    // Export excel staff
    Route::get('/lendings/export', [LendingController::class, 'exportExcel'])->name('lendings.export');

    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('staff.profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('staff.profile.update');
});
