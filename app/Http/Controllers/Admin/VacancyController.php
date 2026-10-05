<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $vacancies = Vacancy::with('department')
            ->when($request->type,   fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest('published_date')
            ->paginate(20)->withQueryString();

        return view('admin.vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.vacancies.form', ['vacancy' => new Vacancy, 'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'reference_number'   => 'nullable|string|max:100',
            'type'               => 'required|in:vacancy,internship,training,scholarship',
            'department_id'      => 'nullable|exists:departments,id',
            'description'        => 'required|string',
            'requirements'       => 'nullable|string',
            'responsibilities'   => 'nullable|string',
            'salary_scale'       => 'nullable|string|max:255',
            'duty_station'       => 'nullable|string|max:255',
            'vacancies_count'    => 'nullable|integer|min:1',
            'application_method' => 'nullable|string',
            'application_email'  => 'nullable|email|max:255',
            'published_date'     => 'required|date',
            'closing_date'       => 'required|date|after:published_date',
            'status'             => 'required|in:open,closed,filled',
            'is_active'          => 'nullable|boolean',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
            'attachments.*'      => 'nullable|file|max:5120',
        ]);

        $data['slug']       = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        $vacancy = Vacancy::create($data);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('vacancies', 'public');
                $vacancy->attachments()->create([
                    'name'      => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        AuditLog::record('create', "Created vacancy: {$vacancy->title}", $vacancy);

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy created successfully.');
    }

    public function edit(Vacancy $vacancy)
    {
        $departments = Department::active()->orderBy('name')->get();
        $vacancy->load('attachments');
        return view('admin.vacancies.form', compact('vacancy', 'departments'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'reference_number'   => 'nullable|string|max:100',
            'type'               => 'required|in:vacancy,internship,training,scholarship',
            'department_id'      => 'nullable|exists:departments,id',
            'description'        => 'required|string',
            'requirements'       => 'nullable|string',
            'responsibilities'   => 'nullable|string',
            'salary_scale'       => 'nullable|string|max:255',
            'duty_station'       => 'nullable|string|max:255',
            'vacancies_count'    => 'nullable|integer|min:1',
            'application_method' => 'nullable|string',
            'application_email'  => 'nullable|email|max:255',
            'published_date'     => 'required|date',
            'closing_date'       => 'required|date',
            'status'             => 'required|in:open,closed,filled',
            'is_active'          => 'nullable|boolean',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $vacancy->update($data);
        AuditLog::record('update', "Updated vacancy: {$vacancy->title}", $vacancy);

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy updated successfully.');
    }

    public function destroy(Vacancy $vacancy)
    {
        foreach ($vacancy->attachments as $att) {
            Storage::disk('public')->delete($att->file_path);
        }
        AuditLog::record('delete', "Deleted vacancy: {$vacancy->title}", $vacancy);
        $vacancy->delete();
        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy deleted.');
    }
}
