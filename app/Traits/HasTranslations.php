<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait HasTranslations
{
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function saveTranslatable(array $translationData)
    {
        $config = config("translatable." . get_class($this));

        foreach ($config['fields'] as $field) {
            $arField = $field . $config['ar_suffix'];
            if (isset($translationData[$arField])) {
                $this->translations()->updateOrCreate(
                    ['field' => $field],
                    ['value' => $translationData[$arField]]
                );
            }
        }
    }

    public static function createWithTranslations(array $attributes, array $translationData = [])
    {
        return DB::transaction(function () use ($attributes, $translationData) {
            // Convert location array to MySQL POINT
            if (isset($attributes['location']) && is_array($attributes['location'])) {
                $loc = $attributes['location'];
                $attributes['location'] = DB::raw(
                    "ST_GeomFromText('POINT({$loc['longitude']} {$loc['latitude']})')"
                );
            }

            $model = static::create($attributes);

            if (!empty($translationData)) {
                $model->saveTranslatable($translationData);
            }

            return $model;
        });
    }

    protected function setTranslations(array $translations)
    {
        foreach ($translations as $field => $value) {
            $this->translations()->updateOrCreate(
                ['field' => $field],
                ['value' => $value]
            );
        }
    }

    public function getTranslation($field, $language = null)
    {
        $language = $language ?? $this->preferences['language'] ?? 'en';

        if ($language === 'ar') {
            return $this->translations
                ->where('field', $field)
                ->first()?->value ?? $this->$field;
        }

        return $this->$field;
    }

    public function getAllTranslations(): array
    {
        return ($this->preferences['language'] ?? 'en') === 'ar'
            ? $this->translations->pluck('value', 'field')->toArray()
            : [];
    }

    protected function translatableFields(): array
    {
        return config("translatable." . get_class($this) . ".fields") ?? [];
    }
}
