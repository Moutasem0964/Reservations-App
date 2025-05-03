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

    public function getTranslation(string $field, string $language = 'en')
    {
        // Always check both eager-loaded and direct access
        if ($language === 'ar') {
            if ($this->relationLoaded('translations')) {
                return $this->translations
                    ->where('field', $field)
                    ->first()?->value ?? $this->$field;
            }

            return $this->translations()
                ->where('field', $field)
                ->value('value') ?? $this->$field;
        }

        return $this->$field;
    }

    // public function getTranslationFromEagerLoaded(string $field, ?string $language = null)
    // {

    //     logger('Language check', [
    //         'passed_language' => $language,
    //         'object_language' => $this->language ?? 'none',
    //         'field' => $field
    //     ]);
    //     $language = $language ?? $this->language ?? 'en';

    //     if ($language === 'ar') {
    //         // Check both relation existence and null translations
    //         if ($this->relationLoaded('translations') && $this->translations) {
    //             return $this->translations
    //                 ->where('field', $field)
    //                 ->first()?->value ?? $this->$field;
    //         }
    //         return $this->getTranslation($field, $language);
    //     }
    //     return $this->$field;
    // }


    protected function translatableFields(): array
    {
        return config("translatable." . get_class($this) . ".fields") ?? [];
    }

    public function setLanguage(string $language)
    {
        $this->language = $language;
        return $this;
    }

    public function validateTranslatableFields($request, $validator, array $fields)
    {
        foreach ($fields as $field) {
            $fieldAr = $field . '_ar';

            $hasOriginal = !empty($request->input($field));
            $hasTranslation = !empty($request->input($fieldAr));

            if ($hasOriginal && !$hasTranslation) {
                $validator->errors()->add($fieldAr, ucfirst($fieldAr) . ' is required when ' . $field . ' is present.');
            }

            if ($hasTranslation && !$hasOriginal) {
                $validator->errors()->add($field, ucfirst($field) . ' is required when ' . $fieldAr . ' is present.');
            }
        }
    }
}
