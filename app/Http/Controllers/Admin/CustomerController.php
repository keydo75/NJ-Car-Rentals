<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->withCount('rentals')
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_initial' => 'nullable|string|max:5',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'loyalty_points' => 'nullable|integer|min:0|max:999999',
        ]);

        $fullName = trim($request->first_name . ($request->middle_initial ? ' ' . $request->middle_initial : '') . ' ' . $request->last_name);

        Customer::create([
            'first_name' => $request->first_name,
            'middle_initial' => $request->middle_initial,
            'last_name' => $request->last_name,
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'loyalty_points' => $request->loyalty_points ?? 0,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        $customer->loadCount('rentals');
        $rentals = $customer->rentals()->with('vehicle')->latest()->paginate(10);
        $inquiries = $customer->inquiries()->with('vehicle')->latest()->paginate(10);
        
        return view('admin.customers.show', compact('customer', 'rentals', 'inquiries'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_initial' => 'nullable|string|max:5',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('customers', 'email')->ignore($customer->id), 'max:255'],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'loyalty_points' => 'nullable|integer|min:0|max:999999',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $fullName = trim($request->first_name . ($request->middle_initial ? ' ' . $request->middle_initial : '') . ' ' . $request->last_name);

        $data = [
            'first_name' => $request->first_name,
            'middle_initial' => $request->middle_initial,
            'last_name' => $request->last_name,
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'loyalty_points' => $request->loyalty_points ?? $customer->loyalty_points,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified customer.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}

