<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TechnicianController extends Controller
{
    public function index()
    {
        $technicians = Technician::all();
        return view('pages.admin.technician.index', compact('technicians'));
    }

    public function create()
    {
        return view('pages.admin.technician.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:15',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Technician');

        $technician_id = 'TCH00' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));

        Technician::create([
            'user_id' => $user->id,
            'id' => $technician_id,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.technician.index')->with('success', 'Technician created successfully!');
    }

    public function show(Technician $technician)
    {
        return view('pages.admin.technician.show', compact('technician'));
    }

    public function edit(Technician $technician)
    {
        return view('pages.admin.technician.edit', compact('technician'));
    }

    public function update(Request $request, Technician $technician)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $technician->user_id,
            'phone' => 'required|string|max:15',
        ]);

        $technician->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $technician->update([
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.technician.index')->with('success', 'Technician updated successfully!');
    }

    public function destroy(Technician $technician)
    {
        $technician->delete();

        return redirect()->route('admin.technician.index')->with('success', 'Technician deleted successfully!');
    }

    public function editPassword($id)
    {
        $technician = Technician::findOrFail($id);
        return view('pages.admin.technician.change-password', compact('technician'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $technician = Technician::findOrFail($id);
        $technician->user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.technician.index')->with('success', 'Password updated successfully!');
    }
}
