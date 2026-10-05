<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::active()->where('show_on_website', true)->orderBy('sort_order')->get();
        return view('public.departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        abort_unless($department->is_active && $department->show_on_website, 404);
        $department->load(['leadership', 'services']);
        return view('public.departments.show', compact('department'));
    }
}
