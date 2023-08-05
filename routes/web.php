<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\StockController;
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
    return view('customer.dashboard');
});

// MIDDLEWARES



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'role:user'])->name('dashboard');

// Route accessible for both User and Admin
Route::middleware(['auth', 'role:user|admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'Index');
        Route::get('/womens', function () {
            return view('customer.women');
        });
    });
});
// Route accessible for users with only Admin role
Route::middleware(['auth','role:admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin', 'AdminIndex');
        //DataTables Routes
        //Payment Methods
        Route::post('paymentmethods/datatables/store', [PaymentMethodController::class, 'store2'])->name('paymentmethods.store2');
        Route::get('paymentmethods/datatables/edit/{id}/', [PaymentMethodController::class, 'edit2']);
        Route::post('paymentmethods/datatables/update', [PaymentMethodController::class, 'update2'])->name('paymentmethods.update2');
        Route::get('paymentmethods/datatables/destroy/{id}/', [PaymentMethodController::class, 'destroy2']);
        Route::get('paymentmethods/datatables', [PaymentMethodController::class, 'datatable'])->name('paymentmethods.datatable2');
        Route::get('paymentmethods/export', [PaymentMethodController::class, 'exportData']);

        //Categories
        Route::post('category/datatables/store', [CategoryController::class, 'store2'])->name('categorys.store');
        Route::get('category/datatables/edit/{id}/', [CategoryController::class, 'edit2']);
        Route::post('category/datatables/update', [CategoryController::class, 'update2'])->name('categorys.update');
        Route::get('category/datatables/destroy/{id}/', [CategoryController::class, 'destroy2']);
        Route::get('categories/datatables', [CategoryController::class, 'datatable'])->name('categorys.datatable');
        Route::get('category/export', [CategoryController::class, 'exportData']);

        //Suppliers
        Route::get('suppliers/datatables', [SupplierController::class, 'datatable'])->name('suppliers.datatable');
        Route::post('suppliers/datatables/store', [SupplierController::class, 'store2'])->name('suppliers.store2');
        Route::get('suppliers/datatables/edit/{id}/', [SupplierController::class, 'edit2']);
        Route::post('suppliers/datatables/update', [SupplierController::class, 'update2'])->name('suppliers.update2');
        Route::get('suppliers/datatables/destroy/{id}/', [SupplierController::class, 'destroy2']);
        Route::get('suppliers/export', [SupplierController::class, 'exportData']);

        //Shippings
        Route::get('shippers/datatables', [ShipperController::class, 'datatable'])->name('shippers.datatable');
        Route::post('shippers/datatables/store', [ShipperController::class, 'store2'])->name('shippers.store2');
        Route::get('shippers/datatables/edit/{id}/', [ShipperController::class, 'edit2']);
        Route::post('shippers/datatables/update', [ShipperController::class, 'update2'])->name('shippers.update2');
        Route::get('shippers/datatables/destroy/{id}/', [ShipperController::class, 'destroy2']);
        Route::get('shippers/export', [ShipperController::class, 'exportData']);

        //Stocks
        Route::get('stocks/datatables', [StockController::class, 'datatable'])->name('stocks.datatable');
        Route::post('stocks/datatables/store', [StockController::class, 'store2'])->name('stocks.store2');
        Route::get('stocks/datatables/edit/{id}/', [StockController::class, 'edit2']);
        Route::post('stocks/datatables/update', [StockController::class, 'update2'])->name('stocks.update2');
        Route::get('stocks/datatables/destroy/{id}/', [StockController::class, 'destroy2']);
        Route::get('stocks/export', [StockController::class, 'exportData']);

        //Items
        Route::get('items/datatables', [ItemController::class, 'datatable'])->name('items.datatable');
        Route::post('items/datatables/store', [ItemController::class, 'store2'])->name('items.store2');
        Route::get('items/datatables/edit/{id}/', [ItemController::class, 'edit2']);
        Route::post('items/datatables/update', [ItemController::class, 'update2'])->name('items.update2');
        Route::get('items/datatables/destroy/{id}/', [ItemController::class, 'destroy2']);
        Route::get('items/export', [ItemController::class, 'exportData']);

        //CRUD Routes
        Route::resource("category", CategoryController::class);
        Route::get('paymentmethods/manage', [PaymentMethodController::class, 'index'])->name('paymentmethods.index');
        Route::get('paymentmethods/create', [PaymentMethodController::class, 'create'])->name('paymentmethods.create');
        Route::post('paymentmethods/store', [PaymentMethodController::class, 'store'])->name('paymentmethods.store');
        Route::get('paymentmethods/edit/{id}', [PaymentMethodController::class, 'edit'])->name('paymentmethods.edit');
        Route::put('paymentmethods/update/{id}', [PaymentMethodController::class, 'update'])->name('paymentmethods.update');
        Route::delete('paymentmethods/destroy{id}', [PaymentMethodController::class, 'destroy'])->name('paymentmethods.destroy');



    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
