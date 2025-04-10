<?php

namespace App\Http\Controllers;

use App\Helpers\StorageHelper;
use App\Http\Requests\AcceptManagerInvitationRequest;
use App\Http\Requests\ManagerInvitationRequest;
use App\Models\Log;
use App\Models\ManagerInvitation;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\SmsService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerInvitationController extends Controller
{

    public function send(ManagerInvitationRequest $request, SmsService $smsService)
    {
        try {
            $user = auth()->user();
            $this->authorize('send', ManagerInvitation::class);

            $request->validated();

            $place = $user->manager->place;

            $recentInvitation = ManagerInvitation::where('place_id', $place->id)
                ->where('phone_number', $request->phone_number)
                ->where('created_at', '>=', now()->subMinutes(5))
                ->exists();

            if ($recentInvitation) {
                return response()->json([
                    'error' => 'An invitation was already sent to this number within the last 5 minutes. Please wait before sending another.'
                ], 429); // 429 Too Many Requests
            }

            ManagerInvitation::where('place_id', $place->id)
                ->where('phone_number', $request->phone_number)
                ->delete();
            $token = Str::random(8);

            ManagerInvitation::create([
                'user_id' => $user->id,
                'place_id' => $place->id,
                'phone_number' => $request->phone_number,
                'token' => $token,
                'expires_at' => now()->addHours(24)
            ]);

            $url = route('accept.manager-invite', ['token' => $token]);
            $message = "You have been invited to manage {$place->name}. Please register here: $url";

            $smsService->send($request->phone_number, $message);

            return response()->json(['message' => 'Your invitation has been sent.'], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    private function verify($token)
    {
        // Find the invitation by token
        $invitation = ManagerInvitation::where('token', $token)->first();

        // Check if the invitation exists and is not expired
        if (!$invitation || now()->greaterThan($invitation->expires_at)) {
            return false;
        }

        return $invitation;
    }

    public function accept_invite(AcceptManagerInvitationRequest $request, $token, SmsService $smsService)
    {
        $invitation = $this->verify($token);
        if (!$invitation) {
            return response()->json(['error' => 'Invalid or expired invitation.'], 400);
        }
        $invitationPhone_number = $invitation->phone_number;
        if ($user = User::where('phone_number', $invitationPhone_number)->first()) {
            return response()->json(['error' => 'the invitee already has an account as ' . $user->role], 400);
        }
        DB::beginTransaction();
        try {
            $user = User::createWithTranslations([
                'first_name' => $request->validated('first_name'),
                'last_name' => $request->validated('last_name'),
                'phone_number' => $invitationPhone_number,
                'password' => Hash::make($request->validated('password')),
                'photo_path' => StorageHelper::storeFile($request->file('photo'), 'users_photos'),
                'preferences' => $request->validated('preferences', ['language' => 'en']),
                'is_active' => false,
            ], [
                'first_name_ar' => $request->validated('first_name_ar'),
                'last_name_ar' => $request->validated('last_name_ar')
            ]);
            $user->manager()->create([
                'user_id' => $user->id,
                'place_id' => $invitation->place_id

            ]);
            $VC = $user->generateVerificationCode('manager_registration');
            $smsService->send($invitationPhone_number, "Your code is: {$VC->code}");
            Log::create([
                'user_id'=>$invitation->user_id,
                'user_role'=>User::find($invitation->user_id)->role,
                'action_type'=>'Inviting a manager to place. place_id = '.$invitation->place_id,
                'object_type'=>'User',
                'object_id'=>$user->id
            ]);
            $invitation->delete();
            DB::commit();
            return response()->json([
                'message' => 'Registered successfuly. A verification code was sent to your phone number. Please verify your account'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
