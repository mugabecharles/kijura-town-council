<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['department', 'ward'])
            ->when($request->status,     fn ($q) => $q->where('status', $request->status))
            ->when($request->department, fn ($q) => $q->where('department_id', $request->department))
            ->when($request->search,     fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20)->withQueryString();

        $departments = Department::active()->orderBy('name')->get();
        return view('admin.projects.index', compact('projects', 'departments'));
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        $wards       = Ward::active()->orderBy('name')->get();
        return view('admin.projects.form', ['project' => new Project, 'departments' => $departments, 'wards' => $wards]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'               => 'required|string|max:255',
            'code'                => 'nullable|string|max:50',
            'department_id'       => 'nullable|exists:departments,id',
            'ward_id'             => 'nullable|exists:wards,id',
            'location'            => 'nullable|string|max:255',
            'description'         => 'required|string',
            'full_description'    => 'nullable|string',
            'budget'              => 'nullable|numeric',
            'funding_source'      => 'nullable|string|max:255',
            'contractor'          => 'nullable|string|max:255',
            'contractor_contact'  => 'nullable|string|max:255',
            'start_date'          => 'nullable|date',
            'expected_completion' => 'nullable|date',
            'actual_completion'   => 'nullable|date',
            'progress_percent'    => 'nullable|integer|min:0|max:100',
            'status'              => 'required|in:planned,procurement,ongoing,completed,delayed,suspended',
            'featured_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'map_link'            => 'nullable|url|max:500',
            'is_featured'         => 'nullable|boolean',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:500',
            'images.*'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data['slug']       = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['created_by'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('projects', 'public');
        }

        $project = Project::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('projects/gallery', 'public');
                $project->images()->create(['image' => $path, 'sort_order' => $i]);
            }
        }

        AuditLog::record('create', "Created project: {$project->title}", $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $departments = Department::active()->orderBy('name')->get();
        $wards       = Ward::active()->orderBy('name')->get();
        $project->load(['images', 'updates', 'projectDocuments']);
        return view('admin.projects.form', compact('project', 'departments', 'wards'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'               => 'required|string|max:255',
            'code'                => 'nullable|string|max:50',
            'department_id'       => 'nullable|exists:departments,id',
            'ward_id'             => 'nullable|exists:wards,id',
            'location'            => 'nullable|string|max:255',
            'description'         => 'required|string',
            'full_description'    => 'nullable|string',
            'budget'              => 'nullable|numeric',
            'funding_source'      => 'nullable|string|max:255',
            'contractor'          => 'nullable|string|max:255',
            'contractor_contact'  => 'nullable|string|max:255',
            'start_date'          => 'nullable|date',
            'expected_completion' => 'nullable|date',
            'actual_completion'   => 'nullable|date',
            'progress_percent'    => 'nullable|integer|min:0|max:100',
            'status'              => 'required|in:planned,procurement,ongoing,completed,delayed,suspended',
            'featured_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'map_link'            => 'nullable|url|max:500',
            'is_featured'         => 'nullable|boolean',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:500',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('featured_image')) {
            if ($project->featured_image) Storage::disk('public')->delete($project->featured_image);
            $data['featured_image'] = $request->file('featured_image')->store('projects', 'public');
        }

        $project->update($data);
        AuditLog::record('update', "Updated project: {$project->title}", $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->featured_image) Storage::disk('public')->delete($project->featured_image);
        AuditLog::record('delete', "Deleted project: {$project->title}", $project);
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    public function addUpdate(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'progress_percent' => 'nullable|integer|min:0|max:100',
            'status'           => 'nullable|string',
            'update_date'      => 'required|date',
        ]);
        $data['created_by'] = auth()->id();
        $project->updates()->create($data);

        if (!empty($data['progress_percent'])) {
            $project->update(['progress_percent' => $data['progress_percent']]);
        }

        return redirect()->back()->with('success', 'Project update added.');
    }
}
