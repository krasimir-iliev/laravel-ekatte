<?php

namespace App\Models;

use App\Traits\LogsTranslatableActivity;
use App\Traits\SerializeDate;
use Astrotomic\Translatable\Contracts\Translatable as ContractsTranslatable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Region extends Model implements ContractsTranslatable
{
    /** @use HasFactory<\Database\Factories\RegionFactory> */
    use HasFactory, Translatable, SerializeDate, LogsActivity, LogsTranslatableActivity;

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatedAttributes = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
    ];

    /**
     * The districts in this region.
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'region_id', 'id');
    }

    /**
     * Define activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'code',
        ]);
    }
}
