<?php

use App\Models\User;
use App\Notifications\Api\Auth\VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    Notification::fake();
});

test('user can register', function () {
    $response = $this->postJson('/api/register', [
        'frontend_url' => 'http://localhost:3000',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $user = User::first();

    Notification::assertSentTo(
        $user,
        VerifyEmailNotification::class
    );
});
