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
        ['name' => 'Fine Dining', 'name_ar' => 'عشاء فاخر'],
        ['name' => 'Casual Dining', 'name_ar' => 'مطعم عادي'],
        ['name' => 'Fast Food', 'name_ar' => 'وجبات سريعة'],
        ['name' => 'Bistro', 'name_ar' => 'بيسترو'],
        ['name' => 'Buffet', 'name_ar' => 'بوفيه'],
        
        // Café Types
        ['name' => 'Coffee Shop', 'name_ar' => 'مقهى'],
        ['name' => 'Tea House', 'name_ar' => 'بيت شاي'],
        ['name' => 'Dessert Café', 'name_ar' => 'مقهى حلويات'],
        ['name' => 'Internet Café', 'name_ar' => 'مقهى إنترنت'],
        ['name' => 'Book Café', 'name_ar' => 'مقهى كتاب'],
        
        // Cuisine Types
        ['name' => 'Italian', 'name_ar' => 'إيطالي'],
        ['name' => 'Mexican', 'name_ar' => 'مكسيكي'],
        ['name' => 'Japanese', 'name_ar' => 'ياباني'],
        ['name' => 'Indian', 'name_ar' => 'هندي'],
        ['name' => 'Mediterranean', 'name_ar' => 'متوسطي'],
        
        // Meal Types
        ['name' => 'Breakfast', 'name_ar' => 'فطور'],
        ['name' => 'Brunch', 'name_ar' => 'برانش'],
        ['name' => 'Lunch', 'name_ar' => 'غداء'],
        ['name' => 'Dinner', 'name_ar' => 'عشاء'],
        ['name' => 'Late Night', 'name_ar' => 'وجبة ليلية'],
        
        // Special Features
        ['name' => 'Outdoor Seating', 'name_ar' => 'مقاعد خارجية'],
        ['name' => 'Pet Friendly', 'name_ar' => 'مسموح بالحيوانات'],
        ['name' => 'Vegan Options', 'name_ar' => 'خيارات نباتية'],
        ['name' => 'Gluten-Free Options', 'name_ar' => 'خيارات خالية من الجلوتين'],
        ['name' => 'Live Music', 'name_ar' => 'موسيقى حية']
    ];

    foreach ($categories as $categoryData) {
        // Split the base attributes from translations
        $attributes = ['name' => $categoryData['name']];
        $translations = ['name_ar' => $categoryData['name_ar']];
        
        // Use createWithTranslations to handle both in one transaction
        Category::createWithTranslations($attributes, $translations);
    }
}
}
