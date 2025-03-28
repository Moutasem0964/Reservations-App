<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Public endpoints for viewing places or performing searches
Route::get('/places', [PlaceController::class, 'index']);
Route::get('/places/{id}', [PlaceController::class, 'show']);
Route::get('/places/search', [PlaceController::class, 'search']);

// Client authentication and account management
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);

/*
|--------------------------------------------------------------------------
| Routes Requiring Authentication via Sanctum
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // ------------------------------
    // Client Endpoints
    // ------------------------------
    Route::prefix('client')->group(function () {
        // Use API Resource for Reservations (CRUD)
        Route::apiResource('reservations', ReservationController::class);
        
        // Profile update (expects standard update method in UserController)
        Route::put('profile', [UserController::class, 'update']);
        
        // Reviews (if you have a separate ReviewController, use it; otherwise, if reviews are part of places, adjust accordingly)
        Route::apiResource('reviews', ReviewController::class);
        
        // Feedback
        Route::post('feedback', [FeedbackController::class, 'store']);
        
        // Settings
        Route::put('settings/language', [UserController::class, 'updateLanguage']);
        Route::put('settings/theme', [UserController::class, 'updateTheme']);
        
        // Surveys
        Route::apiResource('surveys', SurveyController::class)->only(['store']);
        
        // Recommendations (for example, a GET endpoint)
        Route::get('recommendations', [SurveyController::class, 'getRecommendations']);
    });

    // ------------------------------
    // Representative (Manager/Employee) Endpoints
    // ------------------------------
    Route::prefix('representative')->group(function () {
        // Representative registration & login endpoints might be public, but included here for authenticated actions
        // Table Management
        Route::apiResource('tables', TableController::class);
        
        // Menu Management
        Route::apiResource('menus', MenuController::class);
        
        // Offers/Events
        Route::apiResource('offers', PlaceController::class)->except(['index', 'show']);
        
        // Reservations management for the restaurant (list, update status, etc.)
        Route::apiResource('reservations', ReservationController::class)->only(['index', 'update']);
        
        // Orders (if orders are separate from reservations)
        Route::apiResource('orders', ReservationController::class)->only(['index', 'update']);
        
        // Employee management (for managers)
        Route::apiResource('employees', UserController::class)->except(['show', 'index']);
        
        // View statistics
        Route::get('statistics', [StatisticsController::class, 'index']);
        
        // Change settings for representative account
        Route::put('settings', [UserController::class, 'updateSettings']);
    });

    // ------------------------------
    // Admin Endpoints
    // ------------------------------
    Route::prefix('admin')->group(function () {
        // Manage Users (listing, enabling/disabling, deleting)
        Route::apiResource('users', UserController::class)->only(['index', 'update', 'destroy']);
        
        // Manage Places (restaurants/cafés)
        Route::apiResource('places', PlaceController::class)->only(['index', 'update', 'destroy']);
        
        // View logs and global statistics
        Route::get('logs', [NotificationController::class, 'logs']);
        Route::get('statistics', [StatisticsController::class, 'global']);
        
        // Manage notifications
        Route::apiResource('notifications', NotificationController::class)->only(['store']);
        
        // Admin settings (language, theme)
        Route::put('settings', [UserController::class, 'updateSettings']);
    });
});
