<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::with(['category', 'department'])
            ->when($request->category,   fn ($q) => $q->where('category_id', $request->category))
            ->when($request->department, fn ($q) => $q->where('department_id', $request->department))
            ->when($request->year,       fn ($q) => $q->where('year', $request->year))
            ->when($request->search,     fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest('published_date')
            ->paginate(20)->withQueryString();

        $categories  = DocumentCategory::where('is_active', true)->orderBy('name')->get();
        $departments = Department::active()->orderBy('name')->get();

        return view('admin.documents.index', compact('documents', 'categories', 'departments'));
    }

    public function create()
    {
        $categories  = DocumentCategory::where('is_active', true)->orderBy('name')->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.documents.form', ['document' => new Document, 'categories' => $categories, 'departments' => $departments]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:document_categories,id',
            'department_id'    => 'nullable|exists:departments,id',
            'description'      => 'nullable|string',
            'file'             => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,png|max:20480',
            'year'             => 'nullable|string|max:4',
            'published_date'   => 'required|date',
            'is_public'        => 'nullable|boolean',
            'is_active'        => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $file               = $request->file('file');
        $data['file_path']  = $file->store('documents', 'public');
        $data['file_name']  = $file->getClientOriginalName();
        $data['file_type']  = $file->getMimeType();
        $data['file_size']  = $file->getSize();
        $data['slug']       = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_public']  = $request->boolean('is_public');
        $data['is_active']  = $request->boolean('is_active');
        $data['uploaded_by'] = auth()->id();

        $document = Document::create($data);
        AuditLog::record('create', "Uploaded document: {$document->title}", $document);

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function edit(Document $document)
    {
        $categories  = DocumentCategory::where('is_active', true)->orderBy('name')->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('admin.documents.form', compact('document', 'categories', 'departments'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:document_categories,id',
            'department_id'    => 'nullable|exists:departments,id',
            'description'      => 'nullable|string',
            'file'             => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,png|max:20480',
            'year'             => 'nullable|string|max:4',
            'published_date'   => 'required|date',
            'is_public'        => 'nullable|boolean',
            'is_active'        => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);
            $file               = $request->file('file');
            $data['file_path']  = $file->store('documents', 'public');
            $data['file_name']  = $file->getClientOriginalName();
            $data['file_type']  = $file->getMimeType();
            $data['file_size']  = $file->getSize();
        }

        $data['is_public'] = $request->boolean('is_public');
        $data['is_active'] = $request->boolean('is_active');
        $document->update($data);
        AuditLog::record('update', "Updated document: {$document->title}", $document);

        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        AuditLog::record('delete', "Deleted document: {$document->title}", $document);
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Document deleted.');
    }

    public function download(Document $document)
    {
        $document->increment('downloads');
        AuditLog::record('download', "Downloaded document: {$document->title}", $document);
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}
