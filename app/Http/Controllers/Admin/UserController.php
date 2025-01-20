<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('roles', 'customer')->get();

        return view('pages.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();

        return view('pages.admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        // dd($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user = $user->load('roles');

        return view('pages.admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $customer = null;
        $technician = null;

        if ($user->hasRole('Admin')) {
            $customer = $user->customer;
            $technician = $user->technician;
        } else {
            $customer = null;
            $technician = null;
        }

        return view('pages.admin.user.edit', compact('user', 'roles', 'customer', 'technician'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->role);

        if ($user->hasRole('Admin')) {
            if ($user->customer) {
                $user->customer->update([
                    'no_customer' => $request->no_customer,
                    'address' => $request->address,
                    'phone' => $request->phone,
                ]);
            }
            if ($user->technician) {
                $user->technician->update([
                    'phone' => $request->phone,
                ]);
            }
        }

        return redirect()->route('admin.user.index')->with('success', 'User and customer data updated successfully.');
    }

    /**
     * Show the form for changing the user's password.
     */
    public function changePasswordForm(User $user)
    {
        return view('pages.admin.user.change-password', compact('user'));
    }

    /**
     * Update the user's password in storage.
     */
    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:5|confirmed',
        ]);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->customer) {
            $user->customer->delete();
        }

        if ($user->technician) {
            $user->technician->delete();
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User and associated data deleted successfully.');
    }

    /**
     * Show the form for creating a new customer's data.
     */
    public function createCustomer(User $user)
    {
        if ($user->customer) {
            return redirect()->back()->with('error', 'Customer data already exists for this user.');
        }

        return view('pages.admin.user.create-customer', compact('user'));
    }

    /**
     * Store a newly created customer's data in storage.
     */
    public function storeCustomer(Request $request, User $user)
    {
        if ($user->customer) {
            return redirect()->back()->with('error', 'Customer data already exists for this user.');
        }

        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);

        $no_customer = 'CP00' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));

        $user->customer()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'no_customer' => $no_customer,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.user.show', $user->id)->with('success', 'Customer data created successfully.');
    }


    public function createTechnician(User $user)
    {
        if ($user->technician) {
            return redirect()->back()->with('error', 'Technician data already exists for this user.');
        }

        return view('pages.admin.user.create-technician', compact('user'));
    }

    /**
     * Store a newly created technician's data in storage.
     */
    public function storeTechnician(Request $request, User $user)
    {
        if ($user->technician) {
            return redirect()->back()->with('error', 'Technician data already exists for this user.');
        }

        $request->validate([
            'phone' => 'required|string|max:15',
        ]);

        $user->technician()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.user.show', $user->id)->with('success', 'Technician data created successfully.');
    }
}
