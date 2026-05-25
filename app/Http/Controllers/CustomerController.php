<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::with('subscriptions')->latest()->paginate(10);
        return view('Customer', ['customers' => $customers]);
    }

    public function show($id): View
    {
        $customer = Customer::with('subscriptions')->findOrFail($id);
        return view('Customer.show', ['customer' => $customer]);
    }
}
