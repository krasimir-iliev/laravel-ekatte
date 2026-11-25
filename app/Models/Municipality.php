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

class Municipality extends Model implements ContractsTranslatable
{
    /** @use HasFactory<\Database\Factories\MunicipalityFactory> */
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
        'district_id',
        'code',
    ];

    /**
     * The district this municipality belongs to.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    /**
     * The town halls in this municipality.
     */
    public function townHalls(): HasMany
    {
        return $this->hasMany(TownHall::class, 'municipality_id', 'id');
    }

    /**
     * Define activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'district.name',
            'code',
        ]);
    }
}
