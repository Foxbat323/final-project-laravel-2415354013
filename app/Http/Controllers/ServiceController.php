<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::with('subscriptions')->latest()->paginate(10);
        return view('Service', ['services' => $services]);
    }

    public function show($id): View
    {
        $service = Service::with('subscriptions')->findOrFail($id);
        return view('Service.show', ['service' => $service]);
    }
}
