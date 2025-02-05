<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customers::latest()->paginate(10);
        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $customer = Customers::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'customer' => $customer
            ]);
        }

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    public function show(Customers $customer)
    {
        return view('pages.customers.show', compact('customer'));
    }

    public function edit(Customers $customer)
    {
        return view('pages.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customers $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:customers,email,{$customer->id}",
            'phone' => 'required|string|max:20',
            'whatsapp' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customers $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
