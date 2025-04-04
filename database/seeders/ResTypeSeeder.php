<?php

namespace Database\Seeders;

use App\Models\Res_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservationTypes = [
            // Standard Dining
            ['name' => 'Dinner Reservation', 'name_ar' => 'حجز عشاء'],
            ['name' => 'Lunch Reservation', 'name_ar' => 'حجز غداء'],
            ['name' => 'Brunch Reservation', 'name_ar' => 'حجز برانش'],
            
            // Event Types
            ['name' => 'Wedding Reception', 'name_ar' => 'حفل زفاف'],
            ['name' => 'Birthday Party', 'name_ar' => 'حفلة عيد ميلاد'],
            ['name' => 'Anniversary Celebration', 'name_ar' => 'احتفال ذكرى'],
            ['name' => 'Corporate Event', 'name_ar' => 'فعالية شركات'],
            ['name' => 'Private Party', 'name_ar' => 'حفلة خاصة'],
            ['name' => 'Networking Event', 'name_ar' => 'فعالية تواصل'],
            ['name' => 'Product Launch', 'name_ar' => 'إطلاق منتج'],
            ['name' => 'Gala Dinner', 'name_ar' => 'عشاء رسمي'],
            
            // Café-Specific Events
            ['name' => 'Poetry Night', 'name_ar' => 'ليلة شعرية'],
            ['name' => 'Live Music Night', 'name_ar' => 'ليلة موسيقى حية'],
            ['name' => 'Art Exhibition', 'name_ar' => 'معرض فني'],
            ['name' => 'Book Club Meeting', 'name_ar' => 'اجتماع نادي الكتاب'],
            
            // Special Venue Bookings
            ['name' => 'Whole Venue Booking', 'name_ar' => 'حجز المكان بالكامل'],
            ['name' => 'Rooftop Event', 'name_ar' => 'فعالية السطح']
        ];
    
        foreach ($reservationTypes as $type) {
            Res_type::createWithTranslations(
                ['name' => $type['name']],
                ['name_ar' => $type['name_ar']]
            );
        }
    }
}
