<?php

namespace App\Services\Ekatte;

use App\Services\Service;
use Illuminate\Database\Eloquent\Model;

abstract class EkatteService extends Service
{
    /**
     * Detect translation changes.
     */
    protected function hasTranslationChanges(Model $model, array $data): bool
    {
        foreach ($model->translations as $translation) {
            $locale = $translation->locale;

            if (isset($data[$locale]['name']) && $data[$locale]['name'] !== $translation->name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Update the specified resource.
     */
    public function update(array $data, int $id): Model
    {
        $model = $this->repository->findOrFail($id);

        if ($this->hasTranslationChanges($model, $data)) {
            $model->updateTimestamps();
        }

        $model->update($data);

        return $model;
    }
}
