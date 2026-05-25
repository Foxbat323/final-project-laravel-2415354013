<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Subscription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $lastMonthCustomers = Customer::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        $activeServices = Service::where('status', 1)->count();
        $lastMonthActiveServices = Service::where('status', 1)
            ->whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])->count();

        $totalSubscriptions = Subscription::count();
        $lastMonthSubscriptions = Subscription::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        $unpaidInvoices = Subscription::where('status', 'unpaid')->count();

        // Calculate percentage changes
        $customerChange = $lastMonthCustomers > 0 
            ? round((($totalCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100) 
            : 0;
        $serviceChange = $lastMonthActiveServices > 0 
            ? round((($activeServices - $lastMonthActiveServices) / $lastMonthActiveServices) * 100) 
            : 0;
        $subscriptionChange = $lastMonthSubscriptions > 0 
            ? round((($totalSubscriptions - $lastMonthSubscriptions) / $lastMonthSubscriptions) * 100) 
            : 0;

        $recentSubscriptions = Subscription::with(['customer', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('Dashboard', [
            'totalCustomers' => $totalCustomers,
            'customerChange' => $customerChange,
            'activeServices' => $activeServices,
            'serviceChange' => $serviceChange,
            'totalSubscriptions' => $totalSubscriptions,
            'subscriptionChange' => $subscriptionChange,
            'unpaidInvoices' => $unpaidInvoices,
            'recentSubscriptions' => $recentSubscriptions,
        ]);
    }
}