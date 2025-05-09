<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\Place;
use App\Models\User;
use App\Services\SmsService;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function login(LoginRequest $request)
    {
        // Get the validated data explicitly
        $validatedData = $request->validated();

        // Retrieve the user by phone number
        $user = User::where('phone_number', $validatedData['phone_number'])->firstOrFail();

        // Check if the user is authorized to login
        if (!Gate::forUser($user)->allows('login', $user)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Attempt login with phone number and password
        if (!auth()->attempt([
            'phone_number' => $validatedData['phone_number'],
            'password' => $validatedData['password']
        ])) {
            return response()->json(['message' => 'Wrong credentials'], 401);
        }

        // Delete previous tokens
        $user->tokens()->delete();

        // Create a new token for the user
        $token = $user->createToken('auth-token', [$user->role])->plainTextToken;

        // Return response with token and user data
        return response()->json([
            'message' => 'You are logged in',
            'token' => $token,
            'user' => new UserResource($user)
        ], 200);
    }


    protected function createUser(RegisterRequest $request)
    {

        return User::createWithTranslations([
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'phone_number' => $request->validated('phone_number'),
            'password' => Hash::make($request->validated('password')),
            'preferences' => $request->validated('preferences', ['language' => 'en']),
            'is_active' => false,
        ], [
            'first_name_ar' => $request->validated('first_name_ar'),
            'last_name_ar' => $request->validated('last_name_ar')
        ]);
    }

    public function clientRegister(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = $this->createUser($request);

            $user->client()->create(['user_id' => $user->id]);

            $verificationCode = $user->generateVerificationCode('client_registration');

            $this->smsService->send($user->phone_number, "Your code is: {$verificationCode->code}");
            DB::commit();

            return response()->json([
                'message' => __('Registration successful'),
                'user' => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Client registration failed: ' . $e->getMessage());
            return response()->json([
                'message' => __('Registration failed'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function managerRegister(RegisterRequest $userRequest, StorePlaceRequest $placeRequest)
    {
        DB::beginTransaction();
        try {
            // 1. Create Place with translations
            $place = Place::createWithTranslations([
                'name' => $placeRequest->validated('place_name'),
                'phone_number' => $placeRequest->validated('place_phone_number'),
                'address' => $placeRequest->validated('place_address'),
                'description' => $placeRequest->validated('place_description'),
                'type' => $placeRequest->validated('place_type'),
                'location' => [ // This will trigger your setLocationAttribute mutator in the Place model
                    'longitude' => $placeRequest->validated('place_longitude'),
                    'latitude' => $placeRequest->validated('place_latitude')
                ],
                'reservation_duration' => $placeRequest->validated('place_reservation_duration', 3),
                'is_active' => false
            ], [
                'name_ar' => $placeRequest->validated('place_name_ar'),
                'address_ar' => $placeRequest->validated('place_address_ar'),
                'type_ar' => $placeRequest->validated('type_ar'),
                'description_ar' => $placeRequest->validated('place_description_ar')
            ]);

            $place->categories()->attach($placeRequest->validated('categories'));
            $place->res_types()->attach($placeRequest->validated('res_types'));

            // 2. Create User with translations
            $user = $this->createUser($userRequest);

            // 3. Generate Verification Code
            $verificationCode = $user->generateVerificationCode('manager_registration');
            $this->smsService->send($user->phone_number, "Your code is: {$verificationCode->code}");
            // 4. Create Manager Relationship
            $user->manager()->create([
                'place_id' => $place->id,
            ]);

            DB::commit();

            return response()->json([
                'message' => __('Manager registration successful. Verification code sent. Verification required.'),
                'manager' => new UserResource($user, $user->preferences['language'] ?? 'en'),
                'place' => new PlaceResource($place, $user->preferences['language'] ?? 'en'), // Pass language here
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Manager registration failed: ' . $e->getMessage());
            return response()->json([
                'message' => __('Registration failed'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    public function adminRegister(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->createUser($request);
            $user->admin()->create(['user_id' => $user->id]);
            $verificationCode = $user->generateVerificationCode('admin_registration');
            $this->smsService->send($user->phone_number, "Your code is: {$verificationCode->code}");
            DB::commit();
            return response()->json([
                'message' => 'Registration successful. Verification code sent. Verification required.',
                'user' => new UserResource($user),
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Manager registration failed: ' . $e->getMessage());
            return response()->json([
                'message' => __('Registration failed'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function employeeRegister(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->authorize('create', Employee::class);
            $user = $this->createUser($request);
            $verificationCode = $user->generateVerificationCode('employee_registration');
            $this->smsService->send($user->phone_number, "Your code is: {$verificationCode->code}");
            $authUser = auth()->user();
            $manager = $authUser->load('manager.place')->manager;
            $emp = $user->employee()->create([
                'user_id' => $user->id,
                'place_id' => $manager->place->id
            ]);
            $authUser->logAction('registring an employee', 'Employee', $emp->id);
            DB::commit();
            return response()->json([
                'messgae' => 'created successfuly. Verification code sent. Verification required.',
                'user' => new UserResource($user)
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Manager registration failed: ' . $e->getMessage());
            return response()->json([
                'message' => __('Registration failed'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function verify(VerifyRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $verificationCode = $user->verifyCode($request->verification_code);

        if (!$verificationCode) {
            return response()->json(['message' => 'Invalid or expired verification code'], 400);
        }

        $verificationCode->update(['is_verified' => true]);
        $user->handlePostVerification($verificationCode->code_type);


        if ($verificationCode->code_type === 'password_reset') {
            // Generate reset token using Laravel's built-in broker
            $token = Password::broker('phones')->createToken($user);

            return response()->json([
                'message' => 'Verification successful!',
                'reset_token' => $token,
                'expires_at' => now()->addMinutes(config('auth.passwords.phones.expire', 60))
            ], 200);
        }

        return response()->json(['message' => 'Verification successful. Please Login!'], 200);
    }

    public function forgotPassword(Request $request)
    {
        $validatedData = $request->validate([
            'phone_number' => 'required|string|exists:users,phone_number'
        ], [
            'phone_number.exists' => 'The provided phone number is not registered.'
        ]);

        try {
            $user = User::where('phone_number', $validatedData['phone_number'])->firstOrFail();
            DB::beginTransaction();
            $verificationCode = $user->latestVerificationCode('password_reset');
            if (!$verificationCode) {
                $verificationCode = $user->generateVerificationCode('password_reset', 1);
                $this->smsService->send($user->phone_number, "Your password reset Code: {$verificationCode->code}");
            }
            DB::commit();
            return response()->json([
                'message' => 'Verification Code has been sent to your phone number. Please verify !',
                'expires_in' => now()->diffInMinutes($verificationCode->expires_at)
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Password reset failed', [
                'phone' => $validatedData['phone_number'],
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'Could not process password reset'
            ], 500);
        }
    }

    public function resetPassword(PasswordResetRequest $request)
    {
        $request->validated();

        // Use Laravel's built-in password reset broker for phones
        $status = Password::broker('phones')->reset(
            [
                'phone_number' => $request->phone_number,
                'password' => $request->password,
                'token' => $request->reset_token
            ],
            function ($user, $password) {
                $user->update(['password' => Hash::make($password)]);
                $user->tokens()->delete();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful. Please login.'], 200);
        }

        return response()->json(['message' => 'Invalid or expired reset token'], 400);
    }

    public function requestNewVerificationCode(Request $request)
    {
        $validatedData = $request->validate([
            'phone_number' => 'required|string|exists:users,phone_number'
        ], [
            'phone_number.exists' => 'The provided phone number is not registered.'
        ]);
        $user = User::where('phone_number', $validatedData['phone_number'])->firstOrFail();
        if ($user->is_active) {
            return response()->json(['message' => 'Account already verified'], 400);
        }
        $role = $user->role;
        $codeType = $role . '_registration';
        $user->verificationCodes()->where('code_type', $codeType)->delete();
        $verificationCode=$user->generateVerificationCode($role . '_registration');
        $this->smsService->send($user->phone_number, "Your new verification code is:  {$verificationCode->code}");
        return response()->json([
            'message' => 'a new verfication code has been sent. Please verify within ' . now()->diffInHours($verificationCode->expires_at)
        ], 200,);
    }
}
