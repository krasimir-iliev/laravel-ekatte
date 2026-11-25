<?php

namespace App\Models;

use App\Traits\LogsTranslatableActivity;
use App\Traits\SerializeDate;
use Astrotomic\Translatable\Contracts\Translatable as ContractsTranslatable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Settlement extends Model implements ContractsTranslatable
{
    /** @use HasFactory<\Database\Factories\SettlementFactory> */
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
        'settlement_kind_id',
        'town_hall_id',
        'ekatte',
    ];

    /**
     * The type of this settlement.
     */
    public function settlementKind(): BelongsTo
    {
        return $this->belongsTo(SettlementKind::class, 'settlement_kind_id', 'id');
    }

    /**
     * The town hall this settlement belongs to.
     */
    public function townHall(): BelongsTo
    {
        return $this->belongsTo(TownHall::class, 'town_hall_id', 'id');
    }

    /**
     * Define activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'settlementKind.name',
            'townHall.name',
            'ekatte',
        ]);
    }
}
