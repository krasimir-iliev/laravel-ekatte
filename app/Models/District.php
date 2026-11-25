<?php

namespace App\Models;

use App\Traits\LogsTranslatableActivity;
use App\Traits\SerializeDate;
use Astrotomic\Translatable\Contracts\Translatable as ContractsTranslatable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class District extends Model implements ContractsTranslatable
{
    /** @use HasFactory<\Database\Factories\DistrictFactory> */
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
        'region_id',
        'code',
    ];

    /**
     * The region this district belongs to.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    /**
     * The municipalities in this district.
     */
    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class, 'district_id', 'id');
    }

    /**
     * Define activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'region.name',
            'code',
        ]);
    }
}
