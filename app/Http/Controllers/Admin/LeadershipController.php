<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Leadership;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadershipController extends Controller
{
    public function index(Request $request)
    {
        $leaders = Leadership::with(['department', 'ward'])
            ->when($request->category, fn ($q) => $q->where('category', $request->category))
            ->orderBy('sort_order')
            ->paginate(20)->withQueryString();

        return view('admin.leadership.index', compact('leaders'));
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        $wards       = Ward::active()->orderBy('name')->get();
        return view('admin.leadership.form', ['leader' => new Leadership, 'departments' => $departments, 'wards' => $wards]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                     => 'required|string|max:255',
            'title'                    => 'required|string|max:255',
            'category'                 => 'required|in:political,technical,councilor,hod',
            'department_id'            => 'nullable|exists:departments,id',
            'ward_id'                  => 'nullable|exists:wards,id',
            'bio'                      => 'nullable|string',
            'photo'                    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone'                    => 'nullable|string|max:50',
            'email'                    => 'nullable|email|max:255',
            'qualifications'           => 'nullable|string|max:500',
            'term_start'               => 'nullable|date',
            'term_end'                 => 'nullable|date',
            'message'                  => 'nullable|string',
            'show_message_on_homepage' => 'nullable|boolean',
            'sort_order'               => 'nullable|integer',
            'is_active'                => 'nullable|boolean',
        ]);

        $data['show_message_on_homepage'] = $request->boolean('show_message_on_homepage');
        $data['is_active']                = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('leadership', 'public');
        }

        $leader = Leadership::create($data);
        AuditLog::record('create', "Created leadership profile: {$leader->name}", $leader);

        return redirect()->route('admin.leadership.index')->with('success', 'Leadership profile created.');
    }

    public function edit(Leadership $leadership)
    {
        $departments = Department::active()->orderBy('name')->get();
        $wards       = Ward::active()->orderBy('name')->get();
        return view('admin.leadership.form', ['leader' => $leadership, 'departments' => $departments, 'wards' => $wards]);
    }

    public function update(Request $request, Leadership $leadership)
    {
        $data = $request->validate([
            'name'                     => 'required|string|max:255',
            'title'                    => 'required|string|max:255',
            'category'                 => 'required|in:political,technical,councilor,hod',
            'department_id'            => 'nullable|exists:departments,id',
            'ward_id'                  => 'nullable|exists:wards,id',
            'bio'                      => 'nullable|string',
            'photo'                    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone'                    => 'nullable|string|max:50',
            'email'                    => 'nullable|email|max:255',
            'qualifications'           => 'nullable|string|max:500',
            'term_start'               => 'nullable|date',
            'term_end'                 => 'nullable|date',
            'message'                  => 'nullable|string',
            'show_message_on_homepage' => 'nullable|boolean',
            'sort_order'               => 'nullable|integer',
            'is_active'                => 'nullable|boolean',
        ]);

        $data['show_message_on_homepage'] = $request->boolean('show_message_on_homepage');
        $data['is_active']                = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($leadership->photo) Storage::disk('public')->delete($leadership->photo);
            $data['photo'] = $request->file('photo')->store('leadership', 'public');
        }

        $leadership->update($data);
        AuditLog::record('update', "Updated leadership profile: {$leadership->name}", $leadership);

        return redirect()->route('admin.leadership.index')->with('success', 'Leadership profile updated.');
    }

    public function destroy(Leadership $leadership)
    {
        if ($leadership->photo) Storage::disk('public')->delete($leadership->photo);
        AuditLog::record('delete', "Deleted leadership profile: {$leadership->name}", $leadership);
        $leadership->delete();
        return redirect()->route('admin.leadership.index')->with('success', 'Profile deleted.');
    }
}
