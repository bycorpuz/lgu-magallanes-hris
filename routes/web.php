<?php

use App\Livewire\AuthenticationPage\Login;
use App\Livewire\AuthenticationPage\Register;
use App\Livewire\DashboardPage\Dashboard;
use App\Livewire\LandingPage\Welcome;
use App\Livewire\User\Logs;
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

Route::get('/', Welcome::class)->name('landing-page');

Route::middleware(['guest','preventBackHistory'])->group(function(){
    // Route::get('/register', Register::class)->name('register');

    Route::get('/login', Login::class)->name('login');
    Route::post('/login-handler',[Login::class,'loginHandler'])->name('login-handler');
});

Route::middleware(['auth','preventBackHistory'])->group(function(){
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/user-logs', Logs::class)->name('user-logs');
});