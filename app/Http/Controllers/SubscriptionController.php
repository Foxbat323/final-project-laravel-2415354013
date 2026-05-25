<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Contracts\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $subscriptions = Subscription::with(['customer', 'service'])->latest()->paginate(10);
        return view('Subscription', ['subscriptions' => $subscriptions]);
    }

    public function show($id): View
    {
        $subscription = Subscription::with(['customer', 'service'])->findOrFail($id);
        return view('Subscription.show', ['subscription' => $subscription]);
    }
}
