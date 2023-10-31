<?php

use App\Livewire\AuthenticationPage\Login;
use App\Livewire\AuthenticationPage\Register;
use App\Livewire\DashboardPage\Dashboard;
use App\Livewire\LandingPage\Welcome;
use App\Livewire\RoleBasedAccessControl\Roles;
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

Route::group(['middleware' => ['guest','preventBackHistory']], function(){
    // Route::get('/register', Register::class)->name('register');

    Route::get('/login', Login::class)->name('login');
    Route::post('/login-handler',[Login::class,'loginHandler'])->name('login-handler');
});

Route::group(['middleware' => ['preventBackHistory', 'auth']], function(){
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

Route::group(['middleware' => ['preventBackHistory', 'auth', 'permission:view-user-logs']], function(){
    Route::get('/user-logs', Logs::class)->name('user-logs');
    Route::get('/rbac-roles', Roles::class)->name('rbac-roles');
});