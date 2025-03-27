<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ManagerLoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StorePlaceRequest;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\Place;
use App\Models\User;
use App\Models\Verification_code;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



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

    public function client_register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'photo_path' => $request->hasFile('photo')
                ? $request->file('photo')->store('clients_photos', 'public')
                : null,
            'preferences' => $validated['preferences'] ?? null,
            'is_active' => true,
        ]);
        $user->client()->create(['user_id' => $user->id]);
        $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
            'user' => new UserResource($user),
        ], 200);
    }

    public function manager_register(RegisterRequest $userRequest, StorePlaceRequest $placeRequest)
    {
        DB::beginTransaction();
        try {
            $userData = $userRequest->validated();
            $placeData = $placeRequest->validated();

            $place = Place::create([
                'name' => $placeData['place_name'],
                'address' => $placeData['address'],
                'phone_number' => $placeData['place_phone_number'],
                'latitude' => $placeData['latitude'],
                'longitude' => $placeData['longitude'],
                'type' => $placeData['type'],
                'reservation_duration' => $placeData['reservation_duration'] ?? 3,
                'description' => $placeData['description'] ?? null,
                'photo_path' => $placeRequest->hasFile('place_photo')
                    ? $placeRequest->file('place_photo')->store('places_photos', 'public')
                    : null,
                'is_active' => false,
            ]);

            $user = User::create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'phone_number' => $userData['phone_number'],
                'password' => Hash::make($userData['password']),
                'photo_path' => $userRequest->hasFile('photo')
                    ? $userRequest->file('photo')->store('clients_photos', 'public')
                    : null,
                'preferences' => $userData['preferences'] ?? null,
                'is_active' => false,
            ]);

            $verificationCode = Verification_code::create([
                'user_id' => $user->id,
                'code' => Str::random(50),
                'code_type' => 'manager_registration',
                'expires_at' => now()->addHours(24),
                'is_verified' => false

            ]);

            DB::commit();

            $user->manager()->create([
                'user_id' => $user->id,
                'place_id' => $place->id,
                'is_verified' => false
            ]);

            $token=$user->createToken('manager_first_login_only',[$user->role])->plainTextToken;

            return response()->json([
                'message' => 'Registration completed. Please verify your account by logging in.',
                'manager_first_login_only'=>$token,
                'place' => $place,
                'user' => new UserResource($user),
                'verification_code' => $verificationCode
            ], 200);
        }
        
        catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }

    public function admin_register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'photo_path' => $request->hasFile('photo')
                ? $request->file('photo')->store('clients_photos', 'public')
                : null,
            'preferences' => $validated['preferences'] ?? null,
            'is_active' => true,
        ]);
        $user->admin()->create(['user_id' => $user->id]);
        $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
            'user' => new UserResource($user),
        ], 200);
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
        $verificationCode=$user->verificationCodes()->where('code', $request->validated('verification_code'))
            ->where('expires_at', '>', now())
            ->where('is_verified', false)
            ->first();
        if(!$verificationCode){
            return response()->json([
                'message'=>'wrong or expired verification code!'
            ], 401);
        }
        $verificationCode->update([
            'is_verified'=>true
        ]);
        $user->manager()->update(['is_verified'=>true]);
        $user->tokens()->delete();
        $token = $user->createToken('auth-token', [$user->role])->plainTextToken;
        return response()->json([
            'message' => 'You are logged in',
            'token' => $token,
            'user' => new UserResource($user)
        ], 200,);
    }

    public function employee_register(RegisterRequest $request){
        $this->authorize('create',Employee::class);
        $validated=$request->validated();
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'photo_path' => $request->hasFile('photo')
                ? $request->file('photo')->store('clients_photos', 'public')
                : null,
            'preferences' => $validated['preferences'] ?? null,
            'is_active' => true,
        ]);
        $manager = auth()->user()->load('manager.place')->manager;
        $emp=$user->employee()->create([
            'user_id'=>$user->id,
            'place_id'=>$manager->place->id
        ]);
        $token=$user->createToken('auth-token',[$user->role])->plainTextToken;
        $authUser=auth()->user();
        $user->logs()->create([
            'user_id'=>$authUser->id,
            'user_role'=>$authUser->role,
            'action_type'=>'registring an employee',
            'object_type'=>'Employee',
            'object_id'=>$emp->id
        ]);
        return response()->json([
            'messgae'=>'created successfuly',
            'token'=>$token,
            'user'=>new UserResource($user)
        ], 200);
    }
}
