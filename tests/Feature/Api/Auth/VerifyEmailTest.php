<?php

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Str;

test('user can verify email', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'name' => 'Test User',
        'email_verified_at' => null,
    ]);
    $notification = Notification::factory()->create([
        'type' => \App\Enums\Notification::EmailVerification->value,
        'receiver' => $user->email,
        'value' => Str::uuid(),
    ]);

    $response = $this->post('api/email-verification/'.$notification->value);

    $response->assertStatus(200);

    $user->refresh();
    expect($user->email_verified_at)->not->toBeNull();

    $this->assertDatabaseMissing('notifications', [
        'id' => $notification->id,
    ]);
});
