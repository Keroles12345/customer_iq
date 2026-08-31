<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return Customers::latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $customer = Customers::create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:customers,email'],
            'phone' => ['required', 'string', 'max:30'],
        ]));
        return response()->json($customer, 201);
    }

    public function show(Customers $customer)
    {
        return $customer->load('feedback');
    }

    public function update(Request $request, Customers $customer)
    {
        $customer->update($request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', 'unique:customers,email,' . $customer->id],
            'phone' => ['sometimes', 'required', 'string', 'max:30'],
        ]));
        return $customer->fresh();
    }

    public function destroy(Customers $customer)
    {
        $customer->delete();
        return response()->noContent();
    }
}
