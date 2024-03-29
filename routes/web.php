<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutsController;

use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\LoginComponent;
use App\Http\Livewire\LogoutComponent;
use App\Http\Livewire\ForgotPasswordComponent;
use App\Http\Livewire\FormForgotPasswordComponent;
use App\Http\Livewire\EmailVerifyComponent;
use App\Http\Livewire\ProductDetailComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\WhitelistComponent;
use App\Http\Livewire\AccountSettingComponent;
use App\Http\Livewire\OrderedTransctions;
use App\Http\Livewire\TransactionDetail;

use App\Http\Livewire\Admin\DashboardComponent;
use App\Http\Livewire\Admin\CategoryComponent;
use App\Http\Livewire\Admin\ProductComponent;
use App\Http\Livewire\Admin\EcomSettingComponent;
use App\Http\Livewire\Admin\OtpVerfyComponent;
use App\Http\Livewire\Admin\VoucherComponent;
use App\Http\Livewire\Admin\AllOrderComponent;

Auth::routes([
  'login' => false,
  'logout' => false,
  'forgot.pass' => false,
  'password.reset' => false,
  'password.update' => false,
  'password.request' => false,
  'verify' => true
]);

Route::get('/admin-otp-verify', OtpVerfyComponent::class)->name('otp-admin');
Route::get('/email-verify', EmailVerifyComponent::class)->middleware('auth')->name('verification.notice');
    
Route::get('/logout', LogoutComponent::class)->name('logout');
Route::middleware('guest')->group(function () {
  Route::get('/login', LoginComponent::class)->name('login');
  Route::get('/forgot-password', ForgotPasswordComponent::class)->name('forgot.pass');
  Route::get('/password/reset/{token}', FormForgotPasswordComponent::class)->name('password.reset');
  Route::get('/password/reset/', FormForgotPasswordComponent::class)->name('password.request');
});

// Route for user login or not but check email verify
Route::middleware(['verify_email'])->group(function () {
  Route::get('/', HomeComponent::class)->name('home');
  Route::get('/shop', ShopComponent::class)->name('shop');
  Route::get('/contact-us', ContactComponent::class)->name('contact-us');
  Route::get('/detail-product/{product_id}', ProductDetailComponent::class)->name('product.detail');
});

// Route for user login
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
  Route::get('/shoping-cart', CartComponent::class)->name('shoping-cart');
  Route::get('/checkout-cart/{voucher?}', CheckoutComponent::class)->name('checkout-cart');
  Route::get('/whitelist-product', WhitelistComponent::class)->name('whitelist');
  Route::get('/account-setting/{activeId?}', AccountSettingComponent::class)->name('account-setting');
  Route::get('/ordered-transaction/{activeId?}', OrderedTransctions::class)->name('ordered-transaction');
});
// Route for user owner login
Route::middleware(['auth:sanctum', 'verified', 'auth_owner'])->group(function () {
  Route::get('/transaction-detail/{trans_id}', TransactionDetail::class)->name('transaction-detail');
});

// Route for admin login
Route::middleware(['auth:sanctum', 'verified', 'auth_admin'])->group(function () {
  Route::get('/admin-dashboard', DashboardComponent::class)->name('adm-dashboard');
  Route::get('/admin-category', CategoryComponent::class)->name('adm-category');
  Route::get('/admin-product', ProductComponent::class)->name('adm-product');
  Route::get('/admin-ecomsetting', EcomSettingComponent::class)->name('adm-ecomsetting');
  Route::get('/admin-voucher', VoucherComponent::class)->name('adm-voucher');
  Route::get('/admin-orders', AllOrderComponent::class)->name('adm-orders');
});

// Function for layouts
Route::get('/custom-fun', [LayoutsController::class, 'customFunction'])->name('custom-fun');