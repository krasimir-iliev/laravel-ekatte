<?php

namespace App\Traits;

use Spatie\Activitylog\Models\Activity;

trait LogsTranslatableActivity
{
    /**
     * Runtime snapshot for delete events
     */
    protected array $translationSnapshot = [];

    /**
     * Boot trait (Laravel convention)
     */
    public static function bootLogsTranslatableActivity(): void
    {
        static::deleting(function ($model) {
            $model->loadMissing('translations');

            $model->translationSnapshot = $model->translations->pluck('name', 'locale')->toArray();
        });
    }

    /**
     * Hook before activity is saved
     */
    public function tapActivity(Activity $activity, string $eventName): void
    {
        $properties = $activity->properties->toArray();

        if ($eventName === 'deleted') {
            $properties['old']['name'] = $this->translationSnapshot;
        } else {
            $this->loadMissing('translations');

            if ($eventName === 'updated') {
                $properties['old']['name'] = $this->translations->mapWithKeys(function ($translation) {
                    return [
                        $translation->locale => $translation->getOriginal('name')
                    ];
                })->toArray();
            }

            $properties['attributes']['name'] = $this->translations->pluck('name', 'locale')->toArray();
        }

        $activity->properties = $properties;
    }
}
