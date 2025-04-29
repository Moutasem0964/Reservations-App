<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ManagerInvitationController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;


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

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!'],200);
});





// Authentication and account management
Route::post('/client/register', [AuthController::class, 'clientRegister']);
Route::post('/employee/register', [AuthController::class, 'employeeRegister'])->middleware(['auth:sanctum', 'role:manager']);
Route::post('/manager/register', [AuthController::class, 'managerRegister']);
Route::post('/admin/register', [AuthController::class, 'adminRegister'])->middleware(['auth:sanctum', 'role:super_admin']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/forgot/password', [AuthController::class, 'forgotPassword']);
Route::post('/reset/password', [AuthController::class, 'resetPassword']);
Route::post('/request/new/verification/code', [AuthController::class, 'requestNewVerificationCode']);
Route::post('/accept/manager/invite/{token}', [ManagerInvitationController::class, 'acceptInvite'])
    ->name('accept.manager-invite');


/*
|--------------------------------------------------------------------------
| Routes Requiring Authentication via Sanctum
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // ------------------------------
    // Public Endpoints
    // ------------------------------
    Route::prefix('users')->group(function () {

        Route::put('profile/update', [UserController::class, 'updateProfile']);
        Route::get('places/active', [PlaceController::class, 'getActivePlaces']);
    });

    // ------------------------------
    // Client Endpoints
    // ------------------------------
    Route::prefix('client')->group(function () {
        // Use API Resource for Reservations (CRUD)
        Route::apiResource('reservations', ReservationController::class);


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

    Route::middleware('role:manager')->group(function () {
        Route::prefix('manager')->group(function () {
            Route::post('send/invitation', [ManagerInvitationController::class, 'send']);
        });
    });


    // ------------------------------
    // Representative (Manager/Employee) Endpoints
    // ------------------------------
    Route::middleware('role:manager|employee')->group(function () {
        Route::prefix('representative')->group(function () {
            // Representative registration & login endpoints might be public, but included here for authenticated actions
            // Table Management
            Route::apiResource('tables', TableController::class)->only('store');

            // Menu Management
            Route::apiResource('menus', MenuController::class);

            Route::apiResource('/menu/items',ItemController::class)->only('store');
            Route::post('/menu/store/many/items',[ItemController::class,'storeManyItems']);

            // Offers/Events
            Route::apiResource('offers', PlaceController::class)->except(['index', 'show']);

            // Reservations management for the restaurant (list, update status, etc.)
            Route::apiResource('reservations', ReservationController::class)->only(['index', 'update']);

            // Employee management (for managers)
            Route::apiResource('employees', UserController::class)->except(['show', 'index']);

            // View statistics
            Route::get('statistics', [StatisticsController::class, 'index']);

            // Change settings for representative account
            Route::put('settings', [UserController::class, 'updateSettings']);
        });
    });

    // ------------------------------
    // Admin Endpoints
    // ------------------------------
    Route::middleware('role:admin|super_admin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::apiResource('users', UserController::class)->only(['show', 'index']);
            // Manage Users (listing, enabling/disabling, deleting)
            //Route::apiResource('users', UserController::class)->only(['index', 'update', 'destroy', 'show']);
            Route::put('/user/activation/{id}', [UserController::class, 'userActivationToggle']);
            // Manage Managers (listing, enabling/disabling, deleting)


            // Manage Places (restaurants/cafés)
            //Route::apiResource('places', PlaceController::class)->only(['index', 'update', 'destroy']);
            Route::put('/place/activation/{id}', [PlaceController::class, 'placeActivationToggle']);
            // View logs and global statistics
            Route::get('logs', [NotificationController::class, 'logs']);
            Route::get('statistics', [StatisticsController::class, 'global']);

            // Manage notifications
            Route::apiResource('notifications', NotificationController::class)->only(['store']);

            // Admin settings (language, theme)
            Route::put('settings', [UserController::class, 'updateSettings']);
        });
    });
});
