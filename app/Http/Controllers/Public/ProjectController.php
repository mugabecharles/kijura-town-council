<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Project;
use App\Models\Ward;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::active()
            ->with(['department', 'ward'])
            ->when($request->status,     fn ($q) => $q->where('status', $request->status))
            ->when($request->department, fn ($q) => $q->where('department_id', $request->department))
            ->when($request->ward,       fn ($q) => $q->where('ward_id', $request->ward))
            ->when($request->search,     fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(12)->withQueryString();

        $departments = Department::active()->orderBy('name')->get();
        $wards       = Ward::active()->orderBy('name')->get();

        return view('public.projects.index', compact('projects', 'departments', 'wards'));
    }

    public function show(Project $project)
    {
        abort_unless($project->is_active, 404);
        $project->load(['department', 'ward', 'images', 'updates', 'projectDocuments']);
        $related = Project::active()->where('id', '!=', $project->id)
            ->where(fn ($q) => $q->where('department_id', $project->department_id)->orWhere('ward_id', $project->ward_id))
            ->limit(3)->get();

        return view('public.projects.show', compact('project', 'related'));
    }
}
