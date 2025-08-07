<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::role('Customer')->get();
        $technicians = User::role('Technician')->get();

        $subjects = [
            'Internet tidak nyala',
            'Tagihan saya tidak sesuai',
            'Koneksi sangat lambat',
            'Sudah bayar tapi belum aktif',
            'Jaringan sering putus',
            'Pembayaran gagal melalui aplikasi',
            'Sinyal hilang total sejak pagi',
            'Wifi tidak bisa connect',
            'Ingin cetak ulang invoice',
            'Zoom meeting selalu putus',
        ];

        $descriptions = [
            'Sejak pagi tadi internet rumah saya mati total.',
            'Saya sudah membayar tapi status masih tidak aktif.',
            'Internet sering disconnect tiap 5 menit.',
            'Saya tidak bisa akses member area.',
            'Mohon bantu reset koneksi internet saya.',
            'Kenapa tagihan bulan ini naik padahal tidak tambah paket?',
            'Koneksi VPN kantor tidak bisa diakses.',
            'Sudah ganti modem tapi tetap tidak bisa browsing.',
            'Tolong jadwalkan teknisi ke rumah saya secepatnya.',
            'Pembayaran lewat e-wallet gagal terus.',
        ];

        $categories = ['Gangguan Internet', 'Administrasi'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['in_progress', 'pending', 'completed'];

        for ($i = 1; $i <= 20; $i++) {
            $customer = $customers->random();
            $technician = $technicians->random();
            $status = $statuses[array_rand($statuses)];

            Complaint::create([
                'id' => Str::uuid(),
                'customer_id' => $customer->id,
                'subject' => $subjects[array_rand($subjects)],
                'description' => $descriptions[array_rand($descriptions)],
                'category' => $categories[array_rand($categories)],
                'priority' => $priorities[array_rand($priorities)],
                'status' => $status,
                'assigned_technician_id' => $status === 'completed' ? null : $technician->id,
                'schedule' => $status === 'completed' ? null : now()->addDays(rand(1, 7))->toDateString(),
            ]);
        }
    }
}
