<?php

namespace App\Models\Traits;

use App\Models\Translation;

trait HasTranslations
{
    /**
     * Get all translations for the model.
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Get a specific translation for a field.
     */
    public function getTranslation($field, $locale)
    {
        return $this->translations()
            ->where('field', $field)
            ->where('locale', $locale)
            ->first();
    }

    /**
     * Create or update a translation for a field.
     */
    public function setTranslation($field, $locale, $value)
    {
        $translation = $this->translations()
            ->where('field', $field)
            ->where('locale', $locale)
            ->firstOrNew();

        $translation->field = $field;
        $translation->locale = $locale;
        $translation->value = $value;
        $translation->save();
    }
}