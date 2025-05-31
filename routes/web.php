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
use App\Http\Controllers\DriverController;
use App\Http\Controllers\GuidesController;
use App\Models\Hotel;
use App\Http\Controllers\MarkUpValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\QuotationTemplateController;
use App\Http\Controllers\GroupQuotationController;


// Link Storage
Route::get('/linkstorage', function () {
    Illuminate\Support\Facades\Artisan::call('storage:link');
});

/// DB seeder RBAC
Route::get('/run-seeder', function () {
    
    Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => 'Database\Seeders\RolePermissionSeeder'
    ]);
    
    return 'Seeder executed successfully!';
});

Route::get('/', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route::group(['middleware' => ['role:admin|director']], function () {
        // Admin specific routes can be added here
        // Users Routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/role-permissions', [RolePermissionController::class, 'index'])->name('role-permissions.index');
        Route::post('/role-permissions', [RolePermissionController::class, 'updatePermissions'])->name('role-permissions.update');
        Route::get('/user-roles', [UserRoleController::class, 'index'])->name('user-roles.index');
        Route::post('/user-roles', [UserRoleController::class, 'updateRole'])->name('user-roles.update');
    //});

    Route::group(['middleware' => ['permission:manage-customers']], function () {
        // Customers Routes
        Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomersController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');
        Route::get('/customers/{customer}', [CustomersController::class, 'show'])->name('customers.show');
        Route::get('/customers/{customer}/edit', [CustomersController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{customer}', [CustomersController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomersController::class, 'destroy'])->name('customers.destroy');
    });

    Route::group(['middleware' => ['permission:manage-markets']], function () {
        // Markets Routes
        Route::resource('markets', MarketController::class);
    });

    Route::group(['middleware' => ['permission:manage-currencies']], function () {
        // Currencies Routes
        Route::resource('currencies', CurrencyController::class);
    });

    Route::group(['middleware' => ['permission:manage-hotels']], function () {
        // Hotel Routes
        Route::resource('hotels', HotelController::class);
    });

    // Meal Plans Routes
    Route::group(['middleware' => ['permission:manage-meal-plans']], function () {
        // Meal Plans Routes
        Route::resource('meal_plans', MealPlanController::class);
    });

    // Room Categories Routes
    Route::group(['middleware' => ['permission:manage-room-categories']], function () {
        // Room Categories Routes
        Route::resource('room_categories', RoomCategoryController::class);
    });

    // Room Types Routes
    Route::group(['middleware' => ['permission:manage-room-types']], function () {
        // Room Types Routes
        Route::resource('room_types', RoomTypeController::class);
    });

    // Travel_Routes Routes
    Route::group(['middleware' => ['permission:manage-routes']], function () {
        // Travel_Routes Routes
        Route::resource('travel_routes', TravelRouteController::class);
        Route::delete('/travel-routes/delete-image/{id}', [TravelRouteController::class, 'deleteImage'])->name('travel_routes.delete-image');
    });

    // Pax Slabs Routes
    Route::group(['middleware' => ['permission:manage-pax-slabs']], function () {
        // Pax Slabs Routes
        Route::resource('pax_slabs', PaxSlabController::class);
        Route::post('/pax_slabs/reorder', [PaxSlabController::class, 'reorder'])->name('pax_slabs.reorder');
    });
    // Driver Routes
    Route::group(['middleware' => ['permission:manage-drivers']], function () {
        // Driver Routes
        Route::resource('drivers', DriverController::class);
    });

    // Guide Routes
    Route::group(['middleware' => ['permission:manage-guides']], function () {
        // Guide Routes
        Route::resource('guides', GuidesController::class);
    });

    Route::group(['middleware' => ['permission:manage-vehicle-types']], function () {
        // Vehicle Types Routes
        Route::resource('vehicle_types', VehicleTypeController::class);
    });

    Route::group(['middleware' => ['permission:manage-markup-value']], function () {
        // Markup Routes
        Route::resource('markup', MarkUpValueController::class);
    });

    Route::group(['middleware' => ['permission:make-quotations']], function () {
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

        Route::get('/quotations/create/{id}/step5', [QuotationController::class, 'step_five'])->name('quotations.step5');
        Route::post('/quotations/{id}/step5/store', [QuotationController::class, 'store_step_five'])->name('quotations.step5.store');
        Route::get('/quotations/{quotation}/edit-step-five', [QuotationController::class, 'editStepFive'])->name('quotations.edit_step_five');
        Route::put('/quotations/{quotation}/update-step-five', [QuotationController::class, 'updateStepFive'])->name('quotations.update_step_five');

        Route::post('/quotations/update-status/{id}', [QuotationController::class, 'updateStatus'])->name('quotations.updateStatus');
        Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
        Route::get('/quotations/{id}', [QuotationController::class, 'show'])->name('quotations.show');

        Route::get('/quotations-templates/index', [QuotationTemplateController::class, 'index'])->name('quotations_templates.index');
        Route::get('/quotation-templates/create', [QuotationTemplateController::class, 'create'])->name('quotations_templates.create');
        Route::post('/quotation-templates/store', [QuotationTemplateController::class, 'store'])->name('quotations_templates.store');
        Route::get('/quotation-templates/{template}/edit', [QuotationTemplateController::class, 'edit'])->name('quotations_templates.edit');
        Route::put('/quotation-templates/{template}', [QuotationTemplateController::class, 'update'])->name('quotations_templates.update');
        Route::delete('/quotation-templates/{template}', [QuotationTemplateController::class, 'destroy'])->name('quotations_templates.destroy');
        Route::get('/quotation-templates/{template}/show', [QuotationTemplateController::class, 'show'])->name('quotations_templates.show');
        Route::patch('/quotation-templates/{template}/toggle-status', [QuotationTemplateController::class, 'toggleStatus'])->name('quotations_templates.toggle_status');

        // Group Quotation Routes
        Route::prefix('group-quotations')
            ->name('group_quotations.')
            ->group(function () {
                Route::get('/', [GroupQuotationController::class, 'index'])->name('index');

                // Add these new step-by-step routes
                Route::get('/edit/{id}/step-01', [GroupQuotationController::class, 'step_01'])->name('step_01');
                Route::put('/edit/{id}/step-01/store', [GroupQuotationController::class, 'store_step_01'])->name('store_step_01');
                Route::get('/edit/{id}/step-02', [GroupQuotationController::class, 'step_02'])->name('step_02');
                Route::put('/edit/{id}/step-02/store', [GroupQuotationController::class, 'store_step_02'])->name('store_step_02');
                Route::get('/edit/{id}/step-03', [GroupQuotationController::class, 'step_03'])->name('step_03');
                Route::put('/edit/{id}/step-03/store', [GroupQuotationController::class, 'store_step_03'])->name('store_step_03');
                Route::get('/edit/{id}/step-04', [GroupQuotationController::class, 'step_04'])->name('step_04');
                Route::put('/edit/{id}/step-04/store', [GroupQuotationController::class, 'store_step_04'])->name('store_step_04');
                Route::get('/edit/{id}/step-05', [GroupQuotationController::class, 'step_05'])->name('step_05');
                Route::put('/edit/{id}/step-05/store', [GroupQuotationController::class, 'store_step_05'])->name('store_step_05');

                Route::get('/group-quotation/{id}', [GroupQuotationController::class, 'show'])->name('show');
                Route::put('/edit/{id}/step-02/store', [GroupQuotationController::class, 'store_step_02'])->name('store_step_02');
            });

        Route::post('/group-quotations/update-status/{id}', [GroupQuotationController::class, 'updateStatus'])->name('group_quotations.updateStatus');

        Route::get('/select-template', [GroupQuotationController::class, 'selectTemplate'])->name('select_template');

        Route::post('/process-template', [GroupQuotationController::class, 'processTemplateSelection'])->name('process_template');
    });
});

require __DIR__ . '/auth.php';
