<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\UserController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;


// Link Storage 
Route::get('/linkstorage', function () {
    Illuminate\Support\Facades\Artisan::call('storage:link');
});



Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users Routes 
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Customers Routes 
    Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomersController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomersController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomersController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomersController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomersController::class, 'destroy'])->name('customers.destroy');

    // Markets Routes
    Route::resource('markets', MarketController::class);

    // Currencies Routes
    Route::resource('currencies', CurrencyController::class);

    // Hotel Routes 
    Route::resource('hotels', HotelController::class);

    // Meal Plans Routes 
    Route::resource('meal_plans', MealPlanController::class);

    // Room Categories Routes
    Route::resource('room_categories', RoomCategoryController::class);


});

require __DIR__ . '/auth.php';
