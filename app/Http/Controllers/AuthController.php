<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ManagerLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StorePlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Helpers\StorageHelper;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\Place;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json(['message' => 'Wrong credentials'], 401);
        }
        $user = auth()->user();
        $user->tokens()->delete();
        $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
        return response()->json([
            'message' => 'You are logged in',
            'token' => $token,
            'user' => new UserResource($user)
        ], 200,);
    }

    protected function createUser(RegisterRequest $request)
    {

        return User::createWithTranslations([
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'phone_number' => $request->validated('phone_number'),
            'password' => Hash::make($request->validated('password')),
            'photo_path' => StorageHelper::storeFile($request->file('photo'), 'users_photos'),
            'preferences' => $request->validated('preferences', ['language' => 'en']),
            'is_active' => true,
        ], [
            'first_name_ar' => $request->validated('first_name_ar'),
            'last_name_ar' => $request->validated('last_name_ar')
        ]);
    }

    public function client_register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = $this->createUser($request);

            $user->client()->create(['user_id' => $user->id]);

            DB::commit();

            return response()->json([
                'message' => __('Registration successful'),
                'token' => $user->createToken('auth-token', [$user->role])->plainTextToken,
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

    public function manager_register(RegisterRequest $userRequest, StorePlaceRequest $placeRequest)
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
                'location' => [ // This will trigger your setLocationAttribute mutator
                    'longitude' => $placeRequest->validated('place_longitude'),
                    'latitude' => $placeRequest->validated('place_latitude')
                ],
                'reservation_duration' => $placeRequest->validated('place_reservation_duration', 3),
                'photo_path' => StorageHelper::storeFile($placeRequest->file('place_photo'), 'places_photos'),
                'is_active' => false
            ], [
                'name_ar' => $placeRequest->validated('place_name_ar'),
                'address_ar' => $placeRequest->validated('place_address_ar'),
                'description_ar' => $placeRequest->validated('place_description_ar')
            ]);
            $place->categories()->attach($placeRequest->validated('categories'));
            $place->res_types()->attach($placeRequest->validated('res_types'));
            // 2. Create User with translations
            $user = $this->createUser($userRequest);

            // 3. Generate Verification Code
            $verificationCode = $user->generateVerificationCode('manager_registration');

            // 4. Create Manager Relationship
            $user->manager()->create([
                'place_id' => $place->id,
                'is_verified' => false
            ]);

            DB::commit();

            return response()->json([
                'message' => __('Manager registration successful. Verification required.'),
                'verification_code' => $verificationCode->code,
                'manager' => new UserResource($user,$user->preferences['language'] ?? 'en'),
                'place' => new PlaceResource($place, $user->preferences['language'] ?? 'en'), // Pass language here
                'access_token' => $user->createToken('manager_temp_access', [$user->role])->plainTextToken
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


    public function admin_register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->createUser($request);
            DB::commit();
            $user->admin()->create(['user_id' => $user->id]);
            $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
            return response()->json([
                'message' => 'Registration successful',
                'token' => $token,
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

    public function manager_login(ManagerLoginRequest $request)
    {

        $validated = $request->validated();
        $credentials = [
            'phone_number' => $validated['phone_number'],
            'password' => $validated['password']
        ];

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Wrong credentials'], 401);
        }

        $user = auth()->user();
        $verificationCode = $user->latestVerificationCode('manager_registration');
        if (!$verificationCode) {
            return response()->json([
                'message' => 'wrong or expired verification code!'
            ], 401);
        }
        $verificationCode->update([
            'is_verified' => true
        ]);
        $user->manager()->update(['is_verified' => true]);
        $user->tokens()->delete();
        $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
        return response()->json([
            'message' => 'You are logged in',
            'token' => $token,
            'user' => new UserResource($user)
        ], 200,);
    }

    public function employee_register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->authorize('create', Employee::class);
            $user = $this->createUser($request);
            DB::commit();
            $authUser = auth()->user();
            $manager = $authUser->load('manager.place')->manager;
            $emp = $user->employee()->create([
                'user_id' => $user->id,
                'place_id' => $manager->place->id
            ]);
            $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
            $authUser->logAction('registring an employee', 'Employee', $emp->id);
            return response()->json([
                'messgae' => 'created successfuly',
                'token' => $token,
                'user' => new UserResource($user)
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Manager registration failed: ' . $e->getMessage());
            return response()->json([
                'message' => __('Registration failed'),
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
