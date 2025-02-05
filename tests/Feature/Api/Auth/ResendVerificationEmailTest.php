<?php

use App\Models\User;
use App\Notifications\Api\Auth\VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    Notification::fake();
});

test('user can receive verification email again', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);

    $response = $this->postJson('/api/resend-verification-email', [
        'frontend_url' => 'http://localhost:3000',
        'email' => $user->email,
    ]);

    $response->assertStatus(200);

    $user = User::first();

    Notification::assertSentTo(
        $user,
        VerifyEmailNotification::class
    );
});
