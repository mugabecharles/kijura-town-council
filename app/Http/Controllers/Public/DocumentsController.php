<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::where('is_active', true)->where('is_public', true)
            ->with(['category', 'department'])
            ->when($request->category,   fn ($q) => $q->where('category_id', $request->category))
            ->when($request->department, fn ($q) => $q->where('department_id', $request->department))
            ->when($request->year,       fn ($q) => $q->where('year', $request->year))
            ->when($request->search,     fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest('published_date')
            ->paginate(15)->withQueryString();

        $categories  = DocumentCategory::where('is_active', true)->orderBy('name')->get();
        $departments = Department::active()->orderBy('name')->get();
        $years       = Document::where('is_active', true)->whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year');

        return view('public.documents.index', compact('documents', 'categories', 'departments', 'years'));
    }

    public function download(Document $document)
    {
        abort_unless($document->is_active && $document->is_public, 404);
        $document->increment('downloads');
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}
