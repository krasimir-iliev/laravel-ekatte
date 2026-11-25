<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Assigns a permission to a role.
     */
    public function test_it_assigns_a_permission_to_a_role(): void
    {
        // Permission
        $permission = Permission::factory()->create();

        // Role
        $role = Role::factory()->create();

        // Assign permission to role
        $role->givePermissionTo($permission);

        // Role has permission
        $this->assertTrue($role->hasPermissionTo($permission));
    }

    /**
     * Assigns a role to a permission.
     */
    public function test_it_assigns_a_role_to_a_permission(): void
    {
        // Permission
        $permission = Permission::factory()->create();

        // Role
        $role = Role::factory()->create();

        // Assign role to permission
        $permission->assignRole($role);

        // Permission has role
        $this->assertTrue($permission->hasRole($role));
    }
}
