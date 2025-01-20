<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('pages.admin.customer.index', compact('customers'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('pages.admin.customer.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Customer');

        $no_customer = 'CP00' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));

        Customer::create([
            'user_id' => $user->id,
            'no_customer' => $no_customer,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.customer.index')->with('success', 'Customer created successfully!');
    }

    public function show(Customer $customer)
    {
        return view('pages.admin.customer.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('pages.admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.customer.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customer.index')->with('success', 'Customer deleted successfully!');
    }

    public function editPassword($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.admin.customer.change-password', compact('customer'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.customer.index')->with('success', 'Password updated successfully!');
    }
}
