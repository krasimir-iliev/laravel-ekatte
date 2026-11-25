<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a role.
     */
    public function test_it_creates_a_role(): void
    {
        // Role
        $role = Role::factory()->create();

        // Role exists in database
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => $role->name,
            'readonly' => $role->readonly,
        ]);
    }
}
