<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\LoginComponent;
use App\Http\Livewire\LogoutComponent;

use App\Http\Livewire\Admin\DashboardComponent;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeComponent::class)->name('home');
Route::get('/logout', LogoutComponent::class)->name('logout');
Route::get('/shop', ShopComponent::class)->name('shop');
Route::get('/contact-us', ContactComponent::class)->name('contact-us');

Route::middleware('guest')->group(function () {
  Route::get('/login', LoginComponent::class)->name('login');
});

// Route for user login
Route::middleware(['auth:sanctum'])->group(function () {
    
});

// Route for admin login
Route::middleware(['auth:sanctum', 'auth_admin'])->group(function () {
  Route::get('/dashboard', DashboardComponent::class)->name('adm-dashboard');
});