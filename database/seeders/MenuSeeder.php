<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Predefined menu categories
        $menus = [
            'Appetizers',
            'Drinks',
            'Main Course',
            'Desserts',
            'Salads',
            'Breakfast',
            'Sandwiches'
        ];

        // Get all places (3 places: cafe and two restaurants)
        $places = Place::all();

        // Iterate through the places
        foreach ($places as $place) {
            // Create menus for each place
            foreach ($menus as $menuName) {
                $menu = Menu::create([
                    'place_id' => $place->id,
                    'name' => $menuName,
                ]);
            }
        }
    }
}
