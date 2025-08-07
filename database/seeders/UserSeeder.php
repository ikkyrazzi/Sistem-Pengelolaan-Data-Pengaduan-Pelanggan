<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Technician;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123'),
        ]);
        $admin->assignRole('Admin');

        // ======================
        // ✅ Customers (5 user)
        // ======================
        $customers = [
            [
                'name' => 'Andi Saputra',
                'email' => 'andi@gmail.com',
                'phone' => '081234567891',
                'address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'phone' => '081234567892',
                'address' => 'Jl. Anggrek No. 20, Bandung',
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky@gmail.com',
                'phone' => '081234567893',
                'address' => 'Jl. Cemara No. 5, Surabaya',
            ],
            [
                'name' => 'Dewi Ayu',
                'email' => 'dewi@gmail.com',
                'phone' => '081234567894',
                'address' => 'Jl. Mawar No. 7, Medan',
            ],
            [
                'name' => 'Fajar Pratama',
                'email' => 'fajar@gmail.com',
                'phone' => '081234567895',
                'address' => 'Jl. Bunga Raya No. 3, Yogyakarta',
            ],
        ];

        foreach ($customers as $index => $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('123123'),
            ]);
            $user->assignRole('Customer');

            Customer::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'no_customer' => 'CUST' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'address' => $data['address'],
                'phone' => $data['phone'],
            ]);
        }

        // ========================
        // ✅ Technicians (3 user)
        // ========================
        $technicians = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'phone' => '081234567896',
            ],
            [
                'name' => 'Lina Marlina',
                'email' => 'lina@gmail.com',
                'phone' => '081234567897',
            ],
            [
                'name' => 'Agus Hidayat',
                'email' => 'agus@gmail.com',
                'phone' => '081234567898',
            ],
        ];

        foreach ($technicians as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('123123'),
            ]);
            $user->assignRole('Technician');

            Technician::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'phone' => $data['phone'],
            ]);
        }
    }
}
