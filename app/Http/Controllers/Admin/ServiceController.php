<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('department')->orderBy('sort_order')->paginate(20);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.services.form', ['service' => new Service, 'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'department_id'    => 'nullable|exists:departments,id',
            'description'      => 'required|string',
            'full_description' => 'nullable|string',
            'requirements'     => 'nullable|string',
            'fee'              => 'nullable|string|max:255',
            'duration'         => 'nullable|string|max:255',
            'contact_person'   => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:50',
            'contact_email'    => 'nullable|email|max:255',
            'location'         => 'nullable|string|max:255',
            'hours'            => 'nullable|string|max:255',
            'icon'             => 'nullable|string|max:100',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'        => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'sort_order'       => 'nullable|integer',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data['slug']             = Str::slug($data['name']) . '-' . Str::random(4);
        $data['is_active']        = $request->boolean('is_active');
        $data['show_on_homepage'] = $request->boolean('show_on_homepage');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($data);
        AuditLog::record('create', "Created service: {$service->name}", $service);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service)
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.services.form', compact('service', 'departments'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'department_id'    => 'nullable|exists:departments,id',
            'description'      => 'required|string',
            'full_description' => 'nullable|string',
            'requirements'     => 'nullable|string',
            'fee'              => 'nullable|string|max:255',
            'duration'         => 'nullable|string|max:255',
            'contact_person'   => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:50',
            'contact_email'    => 'nullable|email|max:255',
            'location'         => 'nullable|string|max:255',
            'hours'            => 'nullable|string|max:255',
            'icon'             => 'nullable|string|max:100',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'        => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'sort_order'       => 'nullable|integer',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data['is_active']        = $request->boolean('is_active');
        $data['show_on_homepage'] = $request->boolean('show_on_homepage');

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);
        AuditLog::record('update', "Updated service: {$service->name}", $service);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) Storage::disk('public')->delete($service->image);
        AuditLog::record('delete', "Deleted service: {$service->name}", $service);
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
