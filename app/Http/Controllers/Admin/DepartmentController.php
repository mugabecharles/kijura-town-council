<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('sort_order')->paginate(20);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.form', ['department' => new Department]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'short_name'       => 'nullable|string|max:50',
            'description'      => 'nullable|string',
            'head_name'        => 'nullable|string|max:255',
            'head_title'       => 'nullable|string|max:255',
            'phone'            => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:255',
            'location'         => 'nullable|string|max:255',
            'icon'             => 'nullable|string|max:100',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order'       => 'nullable|integer',
            'is_active'        => 'nullable|boolean',
            'show_on_website'  => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data['slug']            = Str::slug($data['name']);
        $data['is_active']       = $request->boolean('is_active');
        $data['show_on_website'] = $request->boolean('show_on_website');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('departments', 'public');
        }

        $dept = Department::create($data);
        AuditLog::record('create', "Created department: {$dept->name}", $dept);

        return redirect()->route('admin.departments.index')->with('success', 'Department created.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.form', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'short_name'       => 'nullable|string|max:50',
            'description'      => 'nullable|string',
            'head_name'        => 'nullable|string|max:255',
            'head_title'       => 'nullable|string|max:255',
            'phone'            => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:255',
            'location'         => 'nullable|string|max:255',
            'icon'             => 'nullable|string|max:100',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order'       => 'nullable|integer',
            'is_active'        => 'nullable|boolean',
            'show_on_website'  => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data['is_active']       = $request->boolean('is_active');
        $data['show_on_website'] = $request->boolean('show_on_website');

        if ($request->hasFile('image')) {
            if ($department->image) Storage::disk('public')->delete($department->image);
            $data['image'] = $request->file('image')->store('departments', 'public');
        }

        $department->update($data);
        AuditLog::record('update', "Updated department: {$department->name}", $department);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        if ($department->image) Storage::disk('public')->delete($department->image);
        AuditLog::record('delete', "Deleted department: {$department->name}", $department);
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted.');
    }
}
