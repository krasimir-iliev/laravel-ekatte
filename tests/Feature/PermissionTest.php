<?php

namespace Tests\Feature;

use App\Models\Permission;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a permission with translations.
     */
    public function test_it_creates_a_permission_with_translations(): void
    {
        // Locales
        $locales = app(Locales::class)->all();

        // Locales are configured
        $this->assertNotEmpty($locales);

        // Permission
        $permission = Permission::factory()->create();

        // Permission exists in database
        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => $permission->name,
        ]);

        // Translations exist in database
        foreach ($locales as $locale) {
            $this->assertDatabaseHas('permission_translations', [
                'permission_id' => $permission->id,
                'locale' => $locale,
                'display_name' => $permission->translate($locale)->display_name,
            ]);
        }
    }
}
