<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingPaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

// All user can access these pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Guest Users can only access these pages. Registerd User and Admin can access these pages as well
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot.show');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('auth.reset.show');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset');
});

// Guest Users cannot access these pages. Registered User and Admin can access these pages. 
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('auth.logout');

// All users can access these contact pages
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/thank-you', [ContactController::class, 'thankYou'])->name('contact.thankyou');

// Only Registered users can reply to messages from the contact page. 
// Admins can also reply to messages from the admin panel.
Route::post('/contact/{message}/reply', [ContactController::class, 'reply'])->middleware('auth')->name('contact.reply');

//All users can access the store and product pages.
Route::get('/store', [ProductController::class, 'index'])->name('store.index');
Route::get('/store/products/{product:slug}', [ProductController::class, 'show'])->name('store.products.show');

// Only Registered users can access the account, booking, cart, and checkout pages. 
// Admins can also access these pages.
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::patch('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::patch('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');

    Route::resource('bookings', BookingController::class);
    Route::get('/bookings/{booking}/payment', [BookingPaymentController::class, 'show'])->name('bookings.payment.show');
    Route::post('/bookings/{booking}/payment', [BookingPaymentController::class, 'process'])->name('bookings.payment.process');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/modify', [CartController::class, 'modify'])->name('cart.modify');
    Route::post('/cart/items', [CartController::class, 'store'])->name('cart.items.store');
    Route::patch('/cart/items/{cartItem}', [CartController::class, 'update'])->name('cart.items.update');
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('cart.items.destroy');

    Route::get('/checkout', [OrderController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [OrderController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/receipt/{order}', [OrderController::class, 'receipt'])->name('checkout.receipt');
});

// Only Admin can access these pages. Registered users and Guest Users cannot access these pages.
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/contact-messages', [AdminController::class, 'contactMessages'])->name('contact-messages');
    Route::get('/contact-messages/{contactMessage}', [AdminController::class, 'showContactMessage'])->name('contact-message.show');
    Route::post('/contact-messages/{contactMessage}/reply', [AdminController::class, 'replyContactMessage'])->name('contact-message.reply');
    Route::delete('/contact-messages/{contactMessage}', [AdminController::class, 'deleteContactMessage'])->name('contact-message.delete');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}/edit', [AdminController::class, 'editBooking'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('bookings.delete');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});
