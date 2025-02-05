<?php

use App\Models\User;

test('registered user can login', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'user' => [
                'name',
                'email',
            ],
        ]);
});
