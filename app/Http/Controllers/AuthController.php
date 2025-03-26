<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Client;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        if(!auth()->attempt($request->validated())){
            return response()->json(['message'=>'Wrong credentials'], 401);
        }
        $user=auth()->user();
        $user->tokens()->delete();
        $token=$user->createToken('auth-token',[$user->role])->plainTextToken;
        return response()->json([
            'message'=>'You are logged in',
            'token'=>$token,
            'user'=>new UserResource($user)
        ], 200,);
    }

    public function client_register(RegisterRequest $request){
        $validated=$request->validated();
        $validated['password']=Hash::make($validated['password']);
        $user=User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'password' => $validated['password'],
            'photo_path' => $validated['photo_path'] ?? null,
            'preferences' => $validated['preferences'] ?? null,
            'is_active' => true,
        ]);
        $user->client()->create([
            'user_id'=>$user->id
        ]);
        $token=$user->createToken('auth-token',[$user->role])->plainTextToken;
        return response()->json([
            'message'=>'Welcome',
            'token'=>$token,
            'user'=>new UserResource($user),
        ], 200,);

    }

    public function manager_register(){

    }

    public function admin_register(){

    }
}
