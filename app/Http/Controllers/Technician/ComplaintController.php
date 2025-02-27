<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Mail\ComplaintStatusUpdated;
use Illuminate\Support\Facades\Mail;

class ComplaintController extends Controller
{
    /**
     * Display the list of complaints assigned to the technician.
     */
    public function complaints()
    {
        $complaints = Complaint::where('assigned_technician_id', auth()->id())
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.technician_baru.complaint', compact('complaints'));
    }

    /**
     * Display the scheduled complaints for the technician.
     */
    public function schedule()
    {
        $scheduledComplaints = Complaint::where('assigned_technician_id', auth()->id())
            ->where('schedule', today())
            ->orderBy('schedule', 'asc')
            ->get();

        return view('pages.technician_baru.schedule', compact('scheduledComplaints'));
    }

    public function show(Complaint $complaint)
    {
        $customer = $complaint->customer;

        return view('pages.technician_baru.complaint_show', compact('complaint', 'customer'));
    }

    /**
     * Display the history of completed complaints.
     */
    public function history()
    {
        $completedComplaints = Complaint::where('assigned_technician_id', auth()->id())
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('pages.technician_baru.history', compact('completedComplaints'));
    }

    /**
     * Update the status of a complaint.
     */

    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::where('id', $id)
            ->where('assigned_technician_id', auth()->id())
            ->firstOrFail();

        $complaint->status = $request->status;
        $complaint->save();

        // Kirim email ke customer
        Mail::to($complaint->customer->email)->send(new ComplaintStatusUpdated($complaint));

        return redirect()->back()->with('success', 'Status keluhan berhasil diperbarui dan email terkirim.');
    }
}
