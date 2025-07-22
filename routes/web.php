<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TravelOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\OfficialStationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\API\OfficialStationController as APIOfficialStationController;
use App\Http\Controllers\DivSecUnitController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmploymentStatusController;

// Dashboard Route
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// API Routes
Route::get('/api/regions/{region}/stations', [APIOfficialStationController::class, 'getByRegion'])
    ->name('api.regions.stations')
    ->middleware('auth');

// Home Route - Redirect to dashboard for authenticated users
Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Employee Routes
    Route::resource('employees', EmployeeController::class);
    
    // Travel Order Routes
    Route::resource('travel-orders', TravelOrderController::class);
    Route::patch('travel-orders/{travelOrder}/cancel', [TravelOrderController::class, 'cancel'])
        ->name('travel-orders.cancel');
    
    // User Management Routes
    Route::resource('users', UserController::class);
    
    // Region Management Routes
    Route::resource('regions', RegionController::class)->except(['show']);
    
    // Official Station Management Routes
    Route::resource('official-stations', OfficialStationController::class)->except(['show']);
    
    // Division/Section/Unit Management Routes
    Route::resource('div-sec-units', DivSecUnitController::class);
    
    // Position Management Routes
    Route::resource('positions', PositionController::class);
    
    // Employment Status Management Routes
    Route::resource('employment-statuses', EmploymentStatusController::class);
    
    // Home Route for authenticated users
    Route::get('/home', function () {
        return redirect()->route('employees.index');
    })->name('home');
});

// Public routes for viewing regions and stations
Route::get('regions/{region}', [RegionController::class, 'show'])->name('regions.show');
Route::get('official-stations/{officialStation}', [OfficialStationController::class, 'show'])->name('official-stations.show');
