<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductStockController as AdminProductStockController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryController as ControllersCategoryController;
use App\Http\Controllers\CheckOngkirController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductStockController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('pages.home');
// });
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/details/{id}', [DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [DetailController::class, 'add'])->name('detail-add');
Route::post('/details', [DetailController::class, 'store']);
Route::get('/detailss/{id}/add-quantity/{quantity}', [DetailController::class, 'addQuantity']);
Route::post('/products/{product}/review', [ProductController::class, 'addReview'])->name('product.review');


Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::get('/register/success', [RegisterController::class, 'success'])->name('register-success');

Route::get('/success', [CartController::class, 'success'])->name('cart-update');

Route::group(['middleware' => ['auth']], function () {


    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/cart{id}', [CartController::class, 'delete'])->name('cart-delete');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');

    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');
    Route::get('/checkout/save', [CheckOngkirController::class, 'store'])->name('checout-save');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/products', [DashboardProductController::class, 'index'])->name('dashboard-product');
    Route::get('/dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-create');
    Route::get('/dashboard/products/{id}', [DashboardProductController::class, 'details'])->name('dashboard-details');

    Route::get('/dashboard/settings', 'DashboardSettingController@store')
        ->name('dashboard-settings-store');
    Route::get('/dashboard/account', 'DashboardSettingController@account')
        ->name('dashboard-settings-account');
    Route::post('/dashboard/update/{redirect}', 'DashboardSettingController@update')
        ->name('dashboard-settings-redirect');

    Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
    Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');
    Route::post('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');
    Route::get('/dashboard/transaction', [DashboardTransactionController::class, 'account'])->name('dashboard-settings');

    Route::get('/dashboard/settings', [DashboardSettingController::class, 'store'])->name('dashboard-settings-store');
    Route::get('/dashboard/account', [DashboardSettingController::class, 'account'])->name('dashboard-settings-account');
    Route::get('province', [DashboardSettingController::class, 'get_province'])->name('province');
    Route::get('/kota/{id}', [DashboardSettingController::class, 'get_city'])->name('cities');
    Route::post('/dashboard/update/{redirect}', [DashboardSettingController::class, 'update'])
        ->name('dashboard-settings-redirect');

    Route::post('/checkout-web', [CheckOngkirController::class, 'checkout'])->name('index-checkout');
    Route::get('province', [CheckOngkirController::class, 'get_province'])->name('province');
    Route::get('/kota/{id}', [CheckOngkirController::class, 'get_city'])->name('cities');
    Route::get('/origin={city_origin}&destination={city_destination}&weight={weight}&courier={courier}', [CheckOngkirController::class, 'get_ongkir']);

    Route::post('/save-province', 'App\Http\Controllers\CheckoutController@saveProvince');
    
});


Route::prefix('admin')
    ->namespace('App\Http\Controllers\Admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
        Route::resource('category', AdminCategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::resource('product-gallery', ProductGalleryController::class);
        Route::resource('transaction', TransactionController::class);
        Route::resource('product_stock', AdminProductStockController::class);
        
    });



Auth::routes();
