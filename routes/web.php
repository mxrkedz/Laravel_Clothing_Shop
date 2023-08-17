<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChartsController;
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
Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/home', 'Index');
        // Route::get('/womens', function () {
        //     return view('customer.women');
        // });
        //ITEMS VIEW
        Route::get('womens', [CartController::class, 'getItems'])->name('getItems');
        Route::get('mens', [CartController::class, 'getItems2'])->name('getItems2');
        Route::get('unisex', [CartController::class, 'getItems3'])->name('getItems3');

        //CART
        Route::post('add-to-cart', [CartController::class, 'addItem']);
        Route::post('delete-cart-item', [CartController::class, 'deleteItem']);
        Route::post('update-cart', [CartController::class, 'updateCart']);
        Route::get('cart', [CartController::class, 'viewCart'])->name('cart.view');
        Route::get('checkout', [CheckoutController::class, 'index']);
        Route::post('place-order', [CheckoutController::class, 'placeOrder'])->name('place-order');
        Route::get('order-success', [CheckoutController::class, 'success'])->name('order.success');
        Route::get('/cart/count', [CartController::class, 'getCartItemCount'])->name('cart.count');
        //Search
        Route::get('/search', [App\Http\Controllers\ItemController::class, 'search'])->name('search');

        // Route::get('cart', [CartController::class, 'cart'])->name('cart');
        // Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');
        // Route::patch('update-cart', [CartController::class, 'update'])->name('update_cart');
        // Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
        // ADD TO CART
        // Route::post('/addcart/{id}', [CartController::class,'addcart']);




    });
});
// Route accessible for users with only Admin role
Route::middleware(['admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin', 'AdminIndex');
        //DataTables Routes
        //Payment Methods
        Route::post('paymentmethods/datatables/store', [PaymentMethodController::class, 'store2'])->name('paymentmethods.store2');
        Route::get('paymentmethods/datatables/edit/{id}/', [PaymentMethodController::class, 'edit2']);
        Route::post('paymentmethods/datatables/update', [PaymentMethodController::class, 'update2'])->name('paymentmethods.update2');
        Route::get('paymentmethods/datatables/destroy/{id}/', [PaymentMethodController::class, 'destroy2']);
        Route::get('paymentmethods/datatables', [PaymentMethodController::class, 'datatable'])->name('paymentmethods.datatable');
        Route::get('paymentmethods/export', [PaymentMethodController::class, 'exportData']);
        Route::post('paymentmethods/import', [PaymentMethodController::class, 'importData']);

        //Categories
        Route::post('category/datatables/store', [CategoryController::class, 'store2'])->name('categorys.store');
        Route::get('category/datatables/edit/{id}/', [CategoryController::class, 'edit2']);
        Route::post('category/datatables/update', [CategoryController::class, 'update2'])->name('categorys.update');
        Route::get('category/datatables/destroy/{id}/', [CategoryController::class, 'destroy2']);
        Route::get('categories/datatables', [CategoryController::class, 'datatable'])->name('categorys.datatable');
        Route::get('category/export', [CategoryController::class, 'exportData']);
        Route::post('category/import', [CategoryController::class, 'importData']);

        //Suppliers
        Route::get('suppliers/datatables', [SupplierController::class, 'datatable'])->name('suppliers.datatable');
        Route::post('suppliers/datatables/store', [SupplierController::class, 'store2'])->name('suppliers.store2');
        Route::get('suppliers/datatables/edit/{id}/', [SupplierController::class, 'edit2']);
        Route::post('suppliers/datatables/update', [SupplierController::class, 'update2'])->name('suppliers.update2');
        Route::get('suppliers/datatables/destroy/{id}/', [SupplierController::class, 'destroy2']);
        Route::get('suppliers/export', [SupplierController::class, 'exportData']);
        Route::post('suppliers/import', [SupplierController::class, 'importData']);

        //Shippings
        Route::get('shippers/datatables', [ShipperController::class, 'datatable'])->name('shippers.datatable');
        Route::post('shippers/datatables/store', [ShipperController::class, 'store2'])->name('shippers.store2');
        Route::get('shippers/datatables/edit/{id}/', [ShipperController::class, 'edit2']);
        Route::post('shippers/datatables/update', [ShipperController::class, 'update2'])->name('shippers.update2');
        Route::get('shippers/datatables/destroy/{id}/', [ShipperController::class, 'destroy2']);
        Route::get('shippers/export', [ShipperController::class, 'exportData']);
        Route::post('shippers/import', [ShipperController::class, 'importData']);

        //CRUD Routes
        // Route::get('paymentmethods', [PaymentMethodController::class, 'index'])->name('paymentmethods.index');
        // Route::get('paymentmethods/create', [PaymentMethodController::class, 'create'])->name('paymentmethods.create');
        // Route::get('paymentmethods/store', [PaymentMethodController::class, 'index'])->name('paymentmethods.index');
        // Route::get('paymentmethods/edit/{id}', [PaymentMethodController::class, 'index'])->name('paymentmethods.index');
        // Route::get('paymentmethods/update/{id}', [PaymentMethodController::class, 'index'])->name('paymentmethods.index');



        Route::resource("category", CategoryController::class);
        Route::resource("paymentmethods", PaymentMethodController::class);
        Route::resource("items", ItemController::class)->middleware('role:admin,user');;
        Route::resource("shippers", ShipperController::class);
        Route::resource("suppliers", SupplierController::class);
        Route::resource("stocks", StockController::class);

        //charts
        Route::get('/charts',[ChartsController::class, 'index'])->name('admin.dashboard');

        

    });
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
