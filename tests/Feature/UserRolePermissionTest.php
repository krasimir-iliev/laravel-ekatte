<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRolePermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assigns a role to a user.
     */
    public function test_it_assigns_a_role_to_a_user(): void
    {
        // Role
        $role = Role::factory()->create();

        // User
        $user = User::factory()->create();

        // Assign role to user
        $user->assignRole($role);

        // User has role
        $this->assertTrue($user->hasRole($role));
    }

    /**
     * Assigns a permission to a user.
     */
    public function test_it_assigns_a_permission_to_a_user(): void
    {
        // Permission
        $permission = Permission::factory()->create();

        // User
        $user = User::factory()->create();

        // Assign permission to user
        $user->givePermissionTo($permission);

        // User has permission
        $this->assertTrue($user->hasPermissionTo($permission));
    }

    /**
     * Assigns a permission from a role to a user.
     */
    public function test_it_assigns_a_permission_from_role_to_a_user(): void
    {
        // Permission
        $permission = Permission::factory()->create();

        // Role
        $role = Role::factory()->create();

        // Assign permission to role
        $role->givePermissionTo($permission);

        // User
        $user = User::factory()->create();

        // Assign role to user
        $user->assignRole($role);

        // User has permission
        $this->assertTrue($user->hasPermissionTo($permission));
    }
}
