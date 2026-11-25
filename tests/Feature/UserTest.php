<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a user.
     */
    public function test_it_creates_a_user(): void
    {
        // User
        $user = User::factory()->create();

        // User exists in database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * Creates a user with a hashed password.
     */
    public function test_it_creates_a_user_with_a_hashed_password(): void
    {
        // User
        $user = User::factory()->create();

        // Password is hashed
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /**
     * Creates an unverified user.
     */
    public function test_it_creates_an_unverified_user(): void
    {
        // Unverified user
        $user = User::factory()->unverified()->create();

        // Email is not verified
        $this->assertNull($user->email_verified_at);
    }
}
