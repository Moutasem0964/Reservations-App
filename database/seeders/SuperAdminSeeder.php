<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'phone_number' => '+963912345678',
            'password' => Hash::make('super123456789'),
            'is_active' => true
        ]);

        Admin::create([
            'user_id' => $super_admin->id,
            'is_super' => true
        ]);
    }
}
