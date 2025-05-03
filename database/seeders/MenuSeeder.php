<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Place;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // English to Arabic menu translations
        $menus = [
            'Appetizers' => 'المقبلات',
            'Drinks' => 'المشروبات',
            'Main Course' => 'الطبق الرئيسي',
            'Desserts' => 'الحلويات',
            'Salads' => 'السلطات',
            'Breakfast' => 'وجبة الإفطار',
            'Sandwiches' => 'السندويشات',
        ];

        // Get all places (3 places: cafe and two restaurants)
        $places = Place::all();

        // Iterate through the places
        foreach ($places as $place) {
            foreach ($menus as $en => $ar) {
                Menu::createWithTranslations(
                    ['place_id' => $place->id, 'name' => $en],
                    ['name_ar' => $ar]
                );
            }
        }
    }
}
