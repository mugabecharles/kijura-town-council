<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::with('department')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest('published_date')
            ->paginate(20)->withQueryString();

        return view('admin.tenders.index', compact('tenders'));
    }

    public function create()
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.tenders.form', ['tender' => new Tender, 'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'reference_number' => 'required|string|max:100|unique:tenders',
            'department_id'    => 'nullable|exists:departments,id',
            'description'      => 'required|string',
            'eligibility'      => 'nullable|string',
            'requirements'     => 'nullable|string',
            'estimated_value'  => 'nullable|numeric',
            'currency'         => 'nullable|string|max:10',
            'contact_person'   => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:50',
            'contact_email'    => 'nullable|email|max:255',
            'published_date'   => 'required|date',
            'closing_date'     => 'required|date|after:published_date',
            'status'           => 'required|in:open,closed,cancelled,awarded',
            'awarded_to'       => 'nullable|string|max:255',
            'award_date'       => 'nullable|date',
            'is_active'        => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'documents.*'      => 'nullable|file|max:10240',
        ]);

        $data['slug']       = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        $tender = Tender::create($data);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('tenders', 'public');
                $tender->documents()->create([
                    'name'      => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        AuditLog::record('create', "Created tender: {$tender->title}", $tender);

        return redirect()->route('admin.tenders.index')->with('success', 'Tender created successfully.');
    }

    public function edit(Tender $tender)
    {
        $departments = Department::active()->orderBy('name')->get();
        $tender->load('documents');
        return view('admin.tenders.form', compact('tender', 'departments'));
    }

    public function update(Request $request, Tender $tender)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'reference_number' => "required|string|max:100|unique:tenders,reference_number,{$tender->id}",
            'department_id'    => 'nullable|exists:departments,id',
            'description'      => 'required|string',
            'eligibility'      => 'nullable|string',
            'requirements'     => 'nullable|string',
            'estimated_value'  => 'nullable|numeric',
            'currency'         => 'nullable|string|max:10',
            'contact_person'   => 'nullable|string|max:255',
            'contact_phone'    => 'nullable|string|max:50',
            'contact_email'    => 'nullable|email|max:255',
            'published_date'   => 'required|date',
            'closing_date'     => 'required|date',
            'status'           => 'required|in:open,closed,cancelled,awarded',
            'awarded_to'       => 'nullable|string|max:255',
            'award_date'       => 'nullable|date',
            'is_active'        => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $tender->update($data);
        AuditLog::record('update', "Updated tender: {$tender->title}", $tender);

        return redirect()->route('admin.tenders.index')->with('success', 'Tender updated successfully.');
    }

    public function destroy(Tender $tender)
    {
        foreach ($tender->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }
        AuditLog::record('delete', "Deleted tender: {$tender->title}", $tender);
        $tender->delete();
        return redirect()->route('admin.tenders.index')->with('success', 'Tender deleted.');
    }
}
