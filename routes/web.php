<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

// MIDDLEWARES

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:user'])->name('dashboard');

// Route accessible for both User and Admin
Route::middleware(['auth', 'role:user|admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'Index');
    });
});

// Route accessible for users with only Admin role
Route::middleware(['auth','role:admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin','AdminIndex');
        //DataTables Routes
        Route::get('users', [UserController::class, 'Index'])->name('users.index');
        Route::post('users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('users/edit/{id}/', [UserController::class, 'edit']);
        Route::post('users/update', [UserController::class, 'update'])->name('users.update');
        Route::get('users/destroy/{id}/', [UserController::class, 'destroy']);
        //CRUD Routes
        Route::resource("category", CategoryController::class);
        Route::resource("paymentmethods", PaymentMethodController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
