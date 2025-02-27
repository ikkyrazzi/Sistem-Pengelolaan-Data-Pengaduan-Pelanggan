<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComplaintsExport;
use App\Helpers\TelegramHelper;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('assignedTechnician')
            ->where('status', 'completed')
            ->whereNotNull('assigned_technician_id')
            ->get();

        return view('pages.admin_baru.complaint.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['customer', 'assignedTechnician']);
        return view('pages.admin_baru.complaint.show', compact('complaint'));
    }

    public function schedule(Complaint $complaint)
    {
        $users = User::role('technician')->get();
        return view('pages.admin_baru.complaint.schedule', compact('complaint', 'users'));
    }

    public function scheduleUpdate(Request $request, Complaint $complaint)
    {
        $request->validate([
            'assigned_technician_id' => 'required|exists:users,id',
            'schedule' => 'nullable|date',
        ]);

        $scheduleDate = $request->schedule ? Carbon::parse($request->schedule)->format('Y-m-d') : null;

        $complaint->update([
            'assigned_technician_id' => $request->assigned_technician_id,
            'schedule' => $scheduleDate,
        ]);

        $technician = User::find($request->assigned_technician_id);

        $message = "🛠 *Jadwal Baru!* 🛠\n\n"
            . "👨‍🔧 *Teknisi*: " . ($technician->name ?? 'Tidak Diketahui') . "\n"
            . "📅 *Tanggal*: " . ($scheduleDate ?? 'Belum Ditentukan') . "\n"
            . "📌 *Deskripsi*: " . ($complaint->description ?? 'Tidak Ada Deskripsi') . "\n"
            . "📂 *Kategori*: " . ($complaint->category ?? 'Tidak Ada Kategori') . "\n"
            . "⚠️ *Prioritas*: " . ucfirst($complaint->priority ?? 'Normal') . "\n\n"
            . "Silakan cek dashboard teknisi untuk detail lebih lanjut.";

        TelegramHelper::sendMessage(env('TELEGRAM_CHAT_ID_TEKNISI'), $message);

        return redirect()->route('admin.complaint.schedule-index')->with('success', 'Technician assigned successfully');
    }

    public function sendTodaySchedule()
    {
        $today = Carbon::today();
        $formattedDate = $today->isoFormat('dddd, D MMMM Y');

        $schedules = DB::table('complaints')
            ->whereDate('complaints.schedule', $today->toDateString())
            ->join('users as teknisi_users', 'complaints.assigned_technician_id', '=', 'teknisi_users.id')
            ->join('users as customers_users', 'complaints.customer_id', '=', 'customers_users.id')
            ->leftJoin('customers', 'customers_users.id', '=', 'customers.user_id')
            ->select(
                'teknisi_users.name as teknisi',
                'customers_users.name as customer_name',
                'customers.no_customer as customer_number',
                'customers.phone as customer_phone',
                'customers.address as customer_address',
                'complaints.schedule as schedule_time',
                'complaints.description',
                'complaints.category',
                'complaints.priority'
            )
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();

        if ($schedules->isEmpty()) {
            TelegramHelper::sendMessage(env('TELEGRAM_CHAT_ID_TEKNISI'), "📅 Tidak ada jadwal teknisi untuk {$formattedDate}.");
            return redirect()->back()->with('info', 'Tidak ada jadwal teknisi untuk hari ini.');
        }

        $groupedSchedules = $schedules->groupBy('teknisi');
        $message = "📅 *Jadwal Teknisi - {$formattedDate}* 📅\n------------------------------\n";

        foreach ($groupedSchedules as $teknisi => $scheduleList) {
            $message .= "\n👨‍🔧 *Teknisi*: {$teknisi}\n------------------------------\n";
            foreach ($scheduleList as $schedule) {
                $priorityIcons = [
                    'urgent' => "🔴 *Urgent!!!*",
                    'high' => "🟠 *High*",
                    'medium' => "🟡 *Medium*",
                    'low' => "🟢 *Low*",
                ];
                $priorityText = $priorityIcons[$schedule->priority] ?? '⚪ UNKNOWN';

                $message .= "⚠️ *Prioritas*: [{$priorityText}]\n"
                    . "➡️ *Jadwal*: {$schedule->schedule_time}\n"
                    . "📝 *Deskripsi*: {$schedule->description}\n"
                    . "📌 *Kategori*: {$schedule->category}\n"
                    . "👤 *Customer*: {$schedule->customer_name}\n"
                    . "🔢 *No. Customer*: {$schedule->customer_number}\n"
                    . "📞 *Phone*: {$schedule->customer_phone}\n"
                    . "📍 *Alamat*: {$schedule->customer_address}\n------------------------------\n";
            }
        }

        TelegramHelper::sendMessage(env('TELEGRAM_CHAT_ID_TEKNISI'), $message);
        return redirect()->back()->with('success', 'Jadwal teknisi berhasil dikirim ke Telegram.');
    }

    public function scheduleIndex()
    {
        $complaints = Complaint::with(['customer', 'assignedTechnician'])
            ->whereIn('status', ['in_progress', 'pending'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin_baru.complaint.schedule-index', compact('complaints'));
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('admin.complaint.index')->with('success', 'Complaint deleted successfully');
    }

    public function export()
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return Excel::download(new ComplaintsExport, "complaints_{$timestamp}.xlsx");
    }
}
