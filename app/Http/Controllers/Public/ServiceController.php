<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services    = Service::active()->with('department')->orderBy('sort_order')->get();
        $departments = Department::active()->whereHas('services', fn ($q) => $q->where('is_active', true))->get();
        return view('public.services.index', compact('services', 'departments'));
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);
        $service->load('department');
        return view('public.services.show', compact('service'));
    }
}
