<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Restaurant Types
            'Fine Dining',
            'Casual Dining',
            'Fast Food',
            'Bistro',
            'Buffet',
            
            // Café Types
            'Coffee Shop',
            'Tea House',
            'Dessert Café',
            'Internet Café',
            'Book Café',
            
            // Cuisine Types (for restaurants)
            'Italian',
            'Mexican',
            'Japanese',
            'Indian',
            'Mediterranean',
            
            // Meal Types
            'Breakfast',
            'Brunch',
            'Lunch',
            'Dinner',
            'Late Night',
            
            // Special Features
            'Outdoor Seating',
            'Pet Friendly',
            'Vegan Options',
            'Gluten-Free Options',
            'Live Music'
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => trim($name)]);
        }
    }
}
