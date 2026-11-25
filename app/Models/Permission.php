<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Astrotomic\Translatable\Contracts\Translatable as ContractsTranslatable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission implements ContractsTranslatable
{
    /** @use HasFactory<\Database\Factories\PermissionFactory> */
    use HasFactory, Translatable, SerializeDate;

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatedAttributes = [
        'display_name',
    ];
}
