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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

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

Route::get('/test-password-reset', function () {
    try {
        $user = App\Models\User::first();
        if (!$user) {
            return response()->json(['error' => 'No user found'], 404);
        }

        $broker = app('auth.password.broker');
        
        // Test sending reset link
        $response = $broker->sendResetLink(['phone_number' => $user->phone_number]);
        
        if ($response !== \Illuminate\Support\Facades\Password::RESET_LINK_SENT) {
            throw new \Exception("Failed to send reset link: {$response}");
        }

        // Verify token was created
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('phone_number', $user->phone_number)
            ->first();

        if (!$tokenRecord) {
            throw new \Exception("Token not created in database");
        }

        // Test password reset
        $resetResponse = $broker->reset(
            [
                'phone_number' => $user->phone_number,
                'token' => $tokenRecord->token,
                'password' => 'newpassword',
                'password_confirmation' => 'newpassword'
            ],
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($resetResponse !== \Illuminate\Support\Facades\Password::PASSWORD_RESET) {
            throw new \Exception("Password reset failed: {$resetResponse}");
        }

        return response()->json([
            'success' => true,
            'token' => $tokenRecord->token,
            'password_reset' => true
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

//Route::delete('/places/{id}', [PlaceController::class, 'destroy']);




// Authentication and account management
Route::post('/client/register', [AuthController::class, 'client_register']);
Route::post('/employee/register', [AuthController::class, 'employee_register'])->middleware(['auth:sanctum', 'role:manager']);
Route::post('/manager/register', [AuthController::class, 'manager_register']);
Route::post('/manager/login', [AuthController::class, 'manager_login']);
Route::post('/admin/register', [AuthController::class, 'admin_register'])->middleware(['auth:sanctum', 'role:super_admin']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/forgot/password', [AuthController::class, 'forgot_password']);


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

        Route::put('profile/update', [UserController::class, 'update_profile']);
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
    Route::middleware('role:admin|super_admin')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::apiResource('users', UserController::class)->only(['show', 'index']);
            // Manage Users (listing, enabling/disabling, deleting)
            //Route::apiResource('users', UserController::class)->only(['index', 'update', 'destroy', 'show']);
            Route::put('/user/activation/{id}', [UserController::class, 'user_activation_toggle']);
            // Manage Managers (listing, enabling/disabling, deleting)


            // Manage Places (restaurants/cafés)
            //Route::apiResource('places', PlaceController::class)->only(['index', 'update', 'destroy']);
            Route::put('/place/activation/{id}', [PlaceController::class, 'place_activation_toggle']);
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
