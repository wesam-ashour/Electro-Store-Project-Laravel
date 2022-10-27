<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CelebrityController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Foundation\Auth\User;
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

Route::get('/', function () {
    $products = Product::with('category')->orderBy('id', 'ASC')->paginate(6);
    return view('welcome', compact('products'));
})->name('home.page');

//home page without auth
Route::get('/accounts', [HomeController::class, 'myAccount'])->name('accounts');
Route::get('/products/view/', [ProductController::class, 'view'])->name('product.view');
Route::get('/products/show/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products/filter/', [ProductController::class, 'view'])->name('filter.view');

//cart
Route::get('cart', [ProductController::class, 'cart'])->name('cart');
Route::post('add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [ProductController::class, 'updateCart'])->name('update.cart');
Route::delete('remove-from-cart', [ProductController::class, 'remove'])->name('remove.from.cart');
Route::get('clearCart', [ProductController::class, 'clearCart'])->name('clearCart');
Route::get('clearCartItems', [ProductController::class, 'removeCartItems'])->name('clearCartItems');

Route::post('applyCouponCode', [ProductController::class, 'applyCouponCode'])->name('applyCouponCode');
Route::get('removeCouponCode', [ProductController::class, 'removeCouponCode'])->name('removeCouponCode');


//checkout
Route::post('/checkout', [ProductController::class, 'getCheckout'])->name('checkout.index');
Route::get('/checkout/details/{id}', [ProductController::class, 'checkoutDetails'])->name('checkout.details');
Route::post('stripe', [ProductController::class, 'placeOrder'])->name('stripe.post');




Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');

    Route::get('wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
    Route::post('favorite-add/{id}', [WishlistController::class, 'favoriteAdd'])->name('favorite.add');
    Route::delete('favorite-remove/{id}', [WishlistController::class, 'favoriteRemove'])->name('favorite.remove');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/details/{id}', [OrderController::class, 'show'])->name('orders.show');


    Route::get('profile', [UserController::class, 'profile'])->name('profile_user');
    Route::put('profile/update/{user}', [UserController::class, 'update_profile'])->name('update_profile');


    Route::post('address/add', [UserController::class, 'add_address'])->name('add_address');
    Route::get('address/{address}', [UserController::class, 'edit_address'])->name('edit_address');
    Route::put('address/update/{id}', [UserController::class, 'update_address'])->name('update_address');
    Route::delete('address/destroy/{address}', [UserController::class, 'destroy_address'])->name('destroy_address');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);

    Route::resource('admins', AdminController::class);
    Route::get('/subadmins/view', [AdminController::class, 'sub_admins'])->name('sub_admins');

    Route::get('/celebrities/view', [CelebrityController::class, 'celebrities_view'])->name('celebrities_view');
    Route::resource('celebrities', CelebrityController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('ads', AdsController::class);

    Route::get('orders/user/{id}', [UserController::class, 'show_orders_user'])->name('show_orders_user');
    Route::get('orders/user/show/{id}', [UserController::class, 'show_orders_details_user'])->name('show_orders_details_user');
    Route::get('orders/user/edit/{id}', [UserController::class, 'edit_orders_user'])->name('edit_orders_user');
    Route::get('orders/user/delete/{id}', [UserController::class, 'delete_orders_user'])->name('delete_orders_user');

    Route::resource('transactions', TransactionController::class);

    Route::get('profile', [UserController::class, 'profile'])->name('profile_admin');
    // Route::get('profile/{user}', [UserController::class, 'edit_profile'])->name('edit_profile');
    // Route::put('profile/update/{user}', [UserController::class, 'update_profile'])->name('update_profile');
    // Route::post('address/add', [UserController::class, 'add_address'])->name('add_address');
    // Route::get('address/{address}', [UserController::class, 'edit_address'])->name('edit_address');
    // Route::put('address/update/{address}', [UserController::class, 'update_address'])->name('update_address');
    // Route::delete('address/destroy/{address}', [UserController::class, 'destroy_address'])->name('destroy_address');
});

Route::prefix('celebrity')->middleware('auth:celebrity')->group(function () {
    Route::get('/dashboard', [CelebrityController::class, 'index'])->name('celebrity.dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('materials', MaterialController::class);

    Route::get('GetSubCatAgainstMainCatEdit/{id}', [ProductController::class, 'GetSubCatAgainstMainCatEdit']);
    Route::get('GetSubCatAgainstMainCatEdit/{id}', [ProductController::class, 'GetSubCatAgainstMainCatEdit']);

});


require __DIR__ . '/celebrityauth.php';

require __DIR__ . '/auth.php';

require __DIR__ . '/adminauth.php';