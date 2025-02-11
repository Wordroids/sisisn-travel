<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\PaxSlabController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\TravelRouteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleTypeController;
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

    // Room Types Routes
    Route::resource('room_types', RoomTypeController::class);

    // Travel_Routes Routes 
    Route::resource('travel_routes', TravelRouteController::class);

    // Pax Slabs Routes
    Route::resource('pax_slabs', PaxSlabController::class);
    Route::post('/pax_slabs/reorder', [PaxSlabController::class, 'reorder'])->name('pax_slabs.reorder');

    //Quotations Routes
    Route::get('/quotations/create/step-01', [QuotationController::class, 'step_one'])->name('quotations.step_one');
    Route::post('/quotations/step-01/store', [QuotationController::class, 'store_step_one'])->name('quotations.store_step_one');
    Route::get('/quotations/{quotation}/edit-step-one', [QuotationController::class, 'editStepOne'])->name('quotations.edit_step_one');
    Route::put('/quotations/{quotation}/update-step-one', [QuotationController::class, 'updateStepOne'])->name('quotations.update_step_one');

    Route::get('/quotations/create/{id}/step2', [QuotationController::class, 'step_two'])->name('quotations.step2');
    Route::post('/quotations/{id}/step2/store', [QuotationController::class, 'store_step_two'])->name('quotations.step2.store');
    Route::get('/quotations/{quotation}/edit-step-two', [QuotationController::class, 'editStepTwo'])->name('quotations.edit_step_two');
    Route::put('/quotations/{quotation}/update-step-two', [QuotationController::class, 'updateStepTwo'])->name('quotations.update_step_two');

    Route::get('/quotations/create/{id}/step3', [QuotationController::class, 'step_three'])->name('quotations.step3');
    Route::post('/quotations/{id}/step3/store', [QuotationController::class, 'store_step_three'])->name('quotations.step3.store');
    Route::get('/quotations/{quotation}/edit-step-three', [QuotationController::class, 'editStepThree'])->name('quotations.edit_step_three');
    Route::put('/quotations/{quotation}/update-step-three', [QuotationController::class, 'updateStepThree'])->name('quotations.update_step_three');

    Route::get('/quotations/create/{id}/step4', [QuotationController::class, 'step_four'])->name('quotations.step4');
    Route::post('/quotations/{id}/step4/store', [QuotationController::class, 'store_step_four'])->name('quotations.step4.store');
    Route::get('/quotations/{quotation}/edit-step-four', [QuotationController::class, 'editStepFour'])->name('quotations.edit_step_four');
    Route::put('/quotations/{quotation}/update-step-four', [QuotationController::class, 'updateStepFour'])->name('quotations.update_step_four');
    
    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/{id}', [QuotationController::class, 'show'])->name('quotations.show');

    



    Route::resource('vehicle_types', VehicleTypeController::class);

    Route::post('/quotations/update-status/{id}', [QuotationController::class, 'updateStatus'])->name('quotations.updateStatus');

});

require __DIR__ . '/auth.php';
