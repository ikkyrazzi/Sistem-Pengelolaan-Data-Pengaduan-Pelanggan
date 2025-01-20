<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123'),
        ]);
        $admin->assignRole('Admin');

        // Buat Customer
        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('123123'),
        ]);
        $customer->assignRole('Customer');

        // Buat Technician
        $technician = User::create([
            'name' => 'Technician',
            'email' => 'technician@gmail.com',
            'password' => bcrypt('123123'),
        ]);
        $technician->assignRole('Technician');
    }
}
