<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Ward;

class AboutController extends Controller
{
    public function index()
    {
        return view('public.about.index');
    }

    public function history()
    {
        return view('public.about.history');
    }

    public function wardsVillages()
    {
        $wards = Ward::active()->with(['villages' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])->orderBy('sort_order')->get();
        return view('public.about.wards-villages', compact('wards'));
    }

    public function location()
    {
        return view('public.about.location');
    }
}
