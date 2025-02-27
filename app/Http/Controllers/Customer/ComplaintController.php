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

        // Daftar kata kunci untuk kategori dan prioritas
        $keywords = [
            'internet mati' => ['category' => 'Gangguan Jaringan', 'priority' => 'urgent'],
            'koneksi putus' => ['category' => 'Gangguan Jaringan', 'priority' => 'urgent'],
            'jaringan lemot' => ['category' => 'Gangguan Jaringan', 'priority' => 'high'],
            'vpn error' => ['category' => 'Gangguan Jaringan', 'priority' => 'high'],
            'wifi tidak bisa' => ['category' => 'Gangguan Jaringan', 'priority' => 'high'],
            'modem tidak menyala' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'reset router' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'ganti modem' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'tagihan belum aktif' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tagihan tidak sesuai' => ['category' => 'Administrasi', 'priority' => 'low'],
            'channel tv hilang' => ['category' => 'Layanan TV', 'priority' => 'medium'],
            'tidak bisa menelepon' => ['category' => 'Gangguan Telepon', 'priority' => 'high'],
            'tidak bisa menerima panggilan' => ['category' => 'Gangguan Telepon', 'priority' => 'high'],
            'telepon tidak ada nada' => ['category' => 'Gangguan Telepon', 'priority' => 'urgent'],
        ];

        // Default kategori dan prioritas
        $category = 'Lainnya';
        $priority = 'low';

        // Matching keyword di subject & description dengan fuzzy matching
        $input_text = strtolower($validated['subject'] . ' ' . $validated['description']);

        $best_match = null;
        $best_score = 0;

        foreach ($keywords as $keyword => $values) {
            similar_text($input_text, strtolower($keyword), $percent_match);

            if ($percent_match > 70) { // Ambang batas kemiripan 70%
                if ($percent_match > $best_score) {
                    $best_score = $percent_match;
                    $best_match = $values;
                }
            }
        }

        // Jika ada kecocokan, gunakan kategori dan prioritas dari hasil matching
        if ($best_match) {
            $category = $best_match['category'];
            $priority = $best_match['priority'];
        }

        // Warna dan ikon untuk prioritas
        $priority_labels = [
            'urgent' => "🔴 *Urgent*",
            'high' => "🟠 *High*",
            'medium' => "🟡 *Medium*",
            'low' => "🟢 *Low*",
        ];

        $priority_display = $priority_labels[$priority] ?? "⚪ *Unknown*";

        // Simpan ke database
        $complaint = Complaint::create([
            'customer_id' => auth()->id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'category' => $category,
            'priority' => $priority,
            'status' => 'in_progress',
        ]);

        // Ambil `no_customer` berdasarkan `customer_id`
        $customer = Customer::where('user_id', auth()->id())->first();
        $no_customer = $customer ? $customer->no_customer : 'N/A';

        // Kirim Notifikasi Telegram ke Admin
        TelegramHelper::sendMessage(
            env('TELEGRAM_CHAT_ID_ADMIN'),
            "📢 *Pengaduan Baru!* 📢\n\n" .
                "🆔 *No Customer:* `{$no_customer}`\n" . // No Customer tampil di notifikasi
                "👤 *Customer:* `" . auth()->user()->name . "`\n" .
                "📌 *Kategori:* `{$category}`\n" .
                "⚠️ *Prioritas:* {$priority_display}\n" .
                "📝 *Deskripsi:* `{$complaint->description}`\n\n" .
                "🔗 [Lihat Detail](http://your-website.com/admin/complaints/{$complaint->id})",
            'MarkdownV2' // Gunakan format Markdown V2 untuk styling
        );

        return redirect()->back()->with('success', 'Complaint berhasil dikirim!');
    }
}
