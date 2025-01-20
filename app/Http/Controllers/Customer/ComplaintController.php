<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
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
            'internet' => [
                'category' => 'Gangguan',
                'priority' => 'high',
            ],
            'lambat' => [
                'category' => 'Gangguan',
                'priority' => 'high',
            ],
            'instalasi' => [
                'category' => 'Instalasi',
                'priority' => 'medium',
            ],
            'tagihan' => [
                'category' => 'Tagihan',
                'priority' => 'low',
            ],
            'tidak sesuai' => [
                'category' => 'Tagihan',
                'priority' => 'low',
            ],
        ];

        $category = 'Lainnya';
        $priority = 'low';

        foreach ($keywords as $keyword => $values) {
            if (
                str_contains(strtolower($validated['subject']), $keyword) ||
                str_contains(strtolower($validated['description']), $keyword)
            ) {
                $category = $values['category'];
                $priority = $values['priority'];
                break;
            }
        }

        Complaint::create([
            'customer_id' => auth()->id(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'category' => $category,
            'priority' => $priority,
            'status' => 'in_progress',
        ]);

        return redirect()->route('customer.history.complaint')->with('success', 'Complaint submitted successfully.');
    }
}
