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

class TownHall extends Model implements ContractsTranslatable
{
    /** @use HasFactory<\Database\Factories\TownHallFactory> */
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
        'municipality_id',
        'code',
    ];

    /**
     * The municipality this town hall belongs to.
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }

    /**
     * The settlements in this town hall.
     */
    public function settlements(): HasMany
    {
        return $this->hasMany(Settlement::class, 'town_hall_id', 'id');
    }

    /**
     * Define activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'municipality.name',
            'code',
        ]);
    }
}
