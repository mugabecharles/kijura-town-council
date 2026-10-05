<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Leadership;

class LeadershipController extends Controller
{
    public function index()
    {
        $political  = Leadership::active()->category('political')->orderBy('sort_order')->get();
        $technical  = Leadership::active()->category('technical')->orderBy('sort_order')->get();
        $councilors = Leadership::active()->category('councilor')->with('ward')->orderBy('sort_order')->get();
        $hods       = Leadership::active()->category('hod')->with('department')->orderBy('sort_order')->get();

        return view('public.leadership.index', compact('political', 'technical', 'councilors', 'hods'));
    }

    public function show(Leadership $leadership)
    {
        $leadership->load(['department', 'ward']);
        return view('public.leadership.show', compact('leadership'));
    }
}
