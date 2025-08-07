<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\TelegramHelper;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Customer;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('customer_id', auth()->id())->get();

        return view('pages.customer.history-complaint', compact('complaints'));
    }

    public function create()
    {
        return view('pages.customer.create-complaint');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $keywords = [
            // Gangguan Internet
            'internet mati' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'koneksi putus' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'jaringan lemot' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'vpn error' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'wifi tidak bisa' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'sinyal hilang' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'tidak bisa browsing' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'akses lambat' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'lag saat streaming' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'putus sambungan' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'tidak bisa buka website' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'disconnect setiap saat' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'buffering terus' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'video tidak jalan' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'gagal sambung internet' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'tidak bisa kirim email' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'zoom ngelag' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'tidak ada internet' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],

            // Administrasi
            'sudah bayar tapi internet mati'       => ['category' => 'Administrasi', 'priority' => 'urgent'],
            'bayar tapi tidak aktif'               => ['category' => 'Administrasi', 'priority' => 'high'],
            'pembayaran gagal'                     => ['category' => 'Administrasi', 'priority' => 'high'],
            'status langganan tidak aktif'         => ['category' => 'Administrasi', 'priority' => 'high'],
            'sudah bayar belum aktif'              => ['category' => 'Administrasi', 'priority' => 'high'],
            'tidak bisa akses billing'             => ['category' => 'Administrasi', 'priority' => 'high'],
            'tidak bisa bayar'                     => ['category' => 'Administrasi', 'priority' => 'high'],
            'gagal login member area'              => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tagihan belum aktif'                  => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tagihan double'                       => ['category' => 'Administrasi', 'priority' => 'medium'],
            'data langganan salah'                 => ['category' => 'Administrasi', 'priority' => 'low'],
            'invoice tidak muncul'                 => ['category' => 'Administrasi', 'priority' => 'low'],
            'jumlah tagihan salah'                 => ['category' => 'Administrasi', 'priority' => 'low'],
            'minta cetak ulang tagihan'           => ['category' => 'Administrasi', 'priority' => 'low'],
            'minta upgrade paket'                  => ['category' => 'Administrasi', 'priority' => 'low'],
            'tagihan tidak sesuai'                => ['category' => 'Administrasi', 'priority' => 'low'],
            'tidak dapat tagihan'                  => ['category' => 'Administrasi', 'priority' => 'low'],

            // Perangkat Rusak
            'modem rusak' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'router mati' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'perangkat tidak menyala' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'lampu indikator merah' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'tidak bisa reset modem' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'wifi nyala tapi tidak konek' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'perangkat panas berlebihan' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'adapter modem rusak' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'kabel power longgar' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'tidak ada lampu di perangkat' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
        ];

        $category = 'Lainnya';
        $priority = 'low';

        $input_text = strtolower($validated['subject'] . ' ' . $validated['description']);

        $best_match = null;
        $best_score = 0;

        foreach ($keywords as $keyword => $values) {
            similar_text($input_text, strtolower($keyword), $percent_match);

            if ($percent_match > 70) {
                if ($percent_match > $best_score) {
                    $best_score = $percent_match;
                    $best_match = $values;
                }
            }
        }

        if ($best_match) {
            $category = $best_match['category'];
            $priority = $best_match['priority'];
        }

        $priority_labels = [
            'urgent' => "🔴 *Urgent*",
            'high' => "🟠 *High*",
            'medium' => "🟡 *Medium*",
            'low' => "🟢 *Low*",
        ];

        $priority_display = $priority_labels[$priority] ?? "⚪ *Unknown*";

        $complaint = Complaint::create([
            'customer_id' => auth()->id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'category' => $category,
            'priority' => $priority,
            'status' => 'in_progress',
        ]);

        $customer = Customer::where('user_id', auth()->id())->first();
        $no_customer = $customer ? $customer->no_customer : 'N/A';

        TelegramHelper::sendMessage(
            env('TELEGRAM_CHAT_ID_ADMIN'),
            "📢 *Pengaduan Baru!* 📢\n\n" .
                "🆔 *No Customer:* `{$no_customer}`\n" .
                "👤 *Customer:* `" . auth()->user()->name . "`\n" .
                "📌 *Kategori:* `{$category}`\n" .
                "⚠️ *Prioritas:* {$priority_display}\n" .
                "📝 *Deskripsi:* `{$complaint->description}`\n\n" .
                "🔗 [Lihat Detail](http://your-website.com/admin/complaints/{$complaint->id})",
            'MarkdownV2'
        );

        return redirect()->back()->with('success', 'Complaint berhasil dikirim!');
    }
}
