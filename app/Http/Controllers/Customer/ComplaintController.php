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
            'akses lambat' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'browsing lambat' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'buffering terus' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'call zoom terputus' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'disconnect setiap saat' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'DNS tidak terdeteksi' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'download lambat' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'error koneksi' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'error saat akses email' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'gagal sambung internet' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'ga bisa akses' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'game disconnect' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'game online putus' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'hasil speedtest rendah' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'hasil tes kecepatan buruk' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'hasil speedtest jelek' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'internet down' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'internet drop malam' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'internet mati' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'internet melambat malam hari' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'internet melambat sore hari' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'internet sering putus' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'internet unstable' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'jaringan lemot' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'kecepatan internet turun' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'kecepatan turun drastis' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'koneksi drop' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'koneksi putus' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'lag saat game online' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'lag saat streaming' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'latency naik' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'latency tinggi' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'lemot banget' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'lemot saat hujan' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'loading terus' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'network error' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'paket cepat tapi lemot' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'ping melonjak' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'ping tinggi' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'putus nyambung' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'putus sambungan' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'putus saat video call' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'sinyal hilang' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'speed download rendah' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'speed test rendah' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'speed upload rendah' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'speed turun' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'speedtest tidak sesuai paket' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'streaming error' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'streaming patah-patah' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'suka disconnect' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'suara putus-putus saat meeting' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'tidak ada internet' => ['category' => 'Gangguan Internet', 'priority' => 'urgent'],
            'tidak bisa akses server' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'tidak bisa browsing' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'tidak bisa buka aplikasi online' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'tidak bisa buka website' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'tidak bisa kirim email' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'tidak bisa streaming youtube' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'tidak sesuai speed paket' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'timeout saat akses web' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'video call ngelag' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'video tidak jalan' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'vpn error' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'web tidak bisa diakses' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'wifi tidak bisa' => ['category' => 'Gangguan Internet', 'priority' => 'high'],
            'youtube tidak bisa dibuka' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],
            'zoom ngelag' => ['category' => 'Gangguan Internet', 'priority' => 'medium'],

            'akun billing terkunci' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'bayar online gagal' => ['category' => 'Administrasi', 'priority' => 'high'],
            'bayar tapi tidak aktif' => ['category' => 'Administrasi', 'priority' => 'high'],
            'bayar via atm tapi mati' => ['category' => 'Administrasi', 'priority' => 'urgent'],
            'bukti pembayaran tidak diterima' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'biaya tidak sesuai' => ['category' => 'Administrasi', 'priority' => 'low'],
            'data langganan salah' => ['category' => 'Administrasi', 'priority' => 'low'],
            'double bayar' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'gagal login member area' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'gagal registrasi billing' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'gagal upgrade paket' => ['category' => 'Administrasi', 'priority' => 'high'],
            'gagal verifikasi pembayaran' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'invoice tidak muncul' => ['category' => 'Administrasi', 'priority' => 'low'],
            'jumlah tagihan salah' => ['category' => 'Administrasi', 'priority' => 'low'],
            'kesalahan tagihan' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'konfirmasi pembayaran' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'member area terkunci' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'minta bukti pembayaran' => ['category' => 'Administrasi', 'priority' => 'low'],
            'minta cetak ulang tagihan' => ['category' => 'Administrasi', 'priority' => 'low'],
            'minta downgrade paket' => ['category' => 'Administrasi', 'priority' => 'low'],
            'minta refund' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'minta upgrade paket' => ['category' => 'Administrasi', 'priority' => 'low'],
            'paket belum aktif' => ['category' => 'Administrasi', 'priority' => 'high'],
            'paket tidak sesuai' => ['category' => 'Administrasi', 'priority' => 'high'],
            'pembayaran gagal' => ['category' => 'Administrasi', 'priority' => 'high'],
            'pembayaran sukses tapi belum aktif' => ['category' => 'Administrasi', 'priority' => 'high'],
            'rekening salah' => ['category' => 'Administrasi', 'priority' => 'high'],
            'refund belum diterima' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'salah paket' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'saldo tidak masuk' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'status langganan tidak aktif' => ['category' => 'Administrasi', 'priority' => 'high'],
            'sudah bayar belum aktif' => ['category' => 'Administrasi', 'priority' => 'high'],
            'sudah bayar tapi internet mati' => ['category' => 'Administrasi', 'priority' => 'urgent'],
            'tagihan belum aktif' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tagihan belum muncul' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tagihan double' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tagihan mendadak naik' => ['category' => 'Administrasi', 'priority' => 'high'],
            'tagihan tidak sesuai' => ['category' => 'Administrasi', 'priority' => 'low'],
            'tidak bisa akses billing' => ['category' => 'Administrasi', 'priority' => 'high'],
            'tidak bisa bayar' => ['category' => 'Administrasi', 'priority' => 'high'],
            'tidak bisa bayar online' => ['category' => 'Administrasi', 'priority' => 'high'],
            'tidak bisa cetak invoice' => ['category' => 'Administrasi', 'priority' => 'low'],
            'tidak bisa login billing' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tidak bisa registrasi billing' => ['category' => 'Administrasi', 'priority' => 'medium'],
            'tidak dapat tagihan' => ['category' => 'Administrasi', 'priority' => 'low'],
            'top up gagal' => ['category' => 'Administrasi', 'priority' => 'high'],
            'ubah metode pembayaran' => ['category' => 'Administrasi', 'priority' => 'medium'],

            'adapter modem rusak' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'antena wifi patah' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'bau terbakar dari modem' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'bodi perangkat retak' => ['category' => 'Perangkat Rusak', 'priority' => 'low'],
            'colokan patah' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'firmware modem corrupt' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'kabel LAN putus' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'kabel optik putus' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'kabel power longgar' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'lampu indikator kuning' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'lampu indikator merah' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'lampu indikator tidak nyala' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'lampu indikator orange' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'modem bau asap' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'modem meledak' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'modem rusak' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'modem sering reboot' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'modem tidak merespon' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'modem update gagal' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'perangkat berdebu' => ['category' => 'Perangkat Rusak', 'priority' => 'low'],
            'perangkat berisik' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'perangkat error saat booting' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'perangkat hang' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'perangkat lambat merespon' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'perangkat tidak bisa connect' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'perangkat tidak menyala' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'perangkat restart sendiri' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'perangkat terbakar' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'port fiber patah' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'port LAN rusak' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'router mati' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'router panas' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'tombol reset tidak fungsi' => ['category' => 'Perangkat Rusak', 'priority' => 'medium'],
            'tidak ada lampu di perangkat' => ['category' => 'Perangkat Rusak', 'priority' => 'urgent'],
            'tidak bisa reset modem' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'tidak terdeteksi di jaringan' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
            'wifi nyala tapi tidak konek' => ['category' => 'Perangkat Rusak', 'priority' => 'high'],
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
