<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResendVerificationEmailRequest;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\Api\Auth\VerifyEmailNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            array_merge(
                $request->validated(),
                ['password' => Hash::make($request->password)],
            )
        );

        $token = Str::uuid();
        $url = $request->validated('frontend_url').'?token='.$token;

        Notification::updateOrCreate([
            'type' => \App\Enums\Notification::EmailVerification,
            'receiver' => $user->email,
        ], [
            'value' => $token,
        ]);

        $user->notify(new VerifyEmailNotification($url));

        return response()->json([
            'message' => 'User created successfully',
        ], 201);
    }

    public function resendVerificationEmail(ResendVerificationEmailRequest $request)
    {
        $user = User::where('email', $request->validated('email'))->first();

        $token = Str::uuid();
        $url = $request->validated('frontend_url').'?token='.$token;

        Notification::updateOrCreate([
            'type' => \App\Enums\Notification::EmailVerification,
            'receiver' => $user->email,
        ], [
            'value' => $token,
        ]);

        $user->notify(new VerifyEmailNotification($url));

        return response()->json([
            'message' => 'Verification email sent successfully',
        ], 200);
    }

    public function verifyEmail(string $token)
    {
        $notification = Notification::where('value', $token)->first();
        $user = User::where('email', $notification->receiver)->first();

        $user->email_verified_at = now();
        $user->save();

        $notification->delete();

        return response()->json([
            'message' => 'Email verified successfully',
        ], 200);
    }
}
