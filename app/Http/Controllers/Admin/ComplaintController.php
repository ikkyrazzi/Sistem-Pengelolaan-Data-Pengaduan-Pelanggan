<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['customer', 'assignedTechnician'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin.complaint.index', compact('complaints'));
    }

    public function create()
    {
        $users = User::all();
        return view('pages.admin.complaint.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:in_progress,completed',
            'assigned_technician_id' => 'nullable|exists:users,id',
        ]);

        Complaint::create([
            'id' => Str::uuid(),
            'customer_id' => $request->customer_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => $request->status,
            'assigned_technician_id' => $request->assigned_technician_id,
        ]);

        return redirect()->route('admin.complaint.index')->with('success', 'Complaint created successfully');
    }

    public function show(Complaint $complaint)
    {
        // Load the related customer and assigned technician to optimize query performance
        $complaint->load(['customer', 'assignedTechnician']);

        return view('pages.admin.complaint.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        $users = User::all();
        return view('pages.admin.complaint.edit', compact('complaint', 'users'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:in_progress,completed',
            'assigned_technician_id' => 'nullable|exists:users,id',
        ]);

        $complaint->update([
            'customer_id' => $request->customer_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => $request->status,
            'assigned_technician_id' => $request->assigned_technician_id,
        ]);

        return redirect()->route('admin.complaint.index')->with('success', 'Complaint updated successfully');
    }

    public function schedule(Complaint $complaint)
    {
        $users = User::role('technician')->get();

        return view('pages.admin.complaint.schedule', compact('complaint', 'users'));
    }

    public function scheduleUpdate(Request $request, Complaint $complaint)
    {
        $request->validate([
            'assigned_technician_id' => 'required|exists:users,id',
            'schedule' => 'nullable|date',
        ]);

        $schedule = $request->has('schedule') ? Carbon::parse($request->schedule)->format('Y-m-d') : null;

        $complaint->update([
            'assigned_technician_id' => $request->assigned_technician_id,
            'schedule' => $schedule,
        ]);

        return redirect()->route('admin.complaint.index')->with('success', 'Technician assigned successfully');
    }


    public function scheduleIndex()
    {
        $complaints = Complaint::with(['assignedTechnician'])->whereNotNull('assigned_technician_id')->get();

        return view('pages.admin.complaint.schedule-index', compact('complaints'));
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('admin.complaint.index')->with('success', 'Complaint deleted successfully');
    }
}
