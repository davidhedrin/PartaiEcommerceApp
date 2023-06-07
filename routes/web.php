<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\LoginComponent;
use App\Http\Livewire\LogoutComponent;
use App\Http\Livewire\ForgotPasswordComponent;
use App\Http\Livewire\EmailVerifyComponent;

use App\Http\Livewire\Admin\DashboardComponent;
use App\Http\Livewire\Admin\CategoryComponent;

Auth::routes(['login' => false, 'logout' => false, 'forgot.pass' => false, 'verify' => true]);
Route::get('/email-verify', EmailVerifyComponent::class)->middleware('auth')->name('verification.notice');
    
Route::get('/logout', LogoutComponent::class)->name('logout');
Route::middleware('guest')->group(function () {
  Route::get('/login', LoginComponent::class)->name('login');
  Route::get('/forgot-password', ForgotPasswordComponent::class)->name('forgot.pass');
});

// Route for user login or not but check email verify
Route::middleware(['verify_email'])->group(function () {
  Route::get('/', HomeComponent::class)->name('home');
  Route::get('/shop', ShopComponent::class)->name('shop');
  Route::get('/contact-us', ContactComponent::class)->name('contact-us');
});

// Route for user login
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

});

// Route for admin login
Route::middleware(['auth:sanctum', 'verified', 'auth_admin'])->group(function () {
  Route::get('/adm-dashboard', DashboardComponent::class)->name('adm-dashboard');
  Route::get('/adm-category', CategoryComponent::class)->name('adm-category');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
