<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Feedback;
use App\Models\FeedbackResponse;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $feedback = Feedback::with(['category', 'department'])
            ->when($request->status,     fn ($q) => $q->where('status', $request->status))
            ->when($request->type,       fn ($q) => $q->where('type', $request->type))
            ->when($request->department, fn ($q) => $q->where('department_id', $request->department))
            ->when($request->search,     fn ($q) => $q->where('subject', 'like', "%{$request->search}%")
                ->orWhere('reference_number', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20)->withQueryString();

        $departments = Department::active()->orderBy('name')->get();
        return view('admin.feedback.index', compact('feedback', 'departments'));
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['category', 'department', 'assignedTo', 'responses.user']);
        $staff = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.feedback.show', compact('feedback', 'staff'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $data = $request->validate([
            'status'      => 'required|in:new,assigned,under_investigation,in_progress,resolved,closed',
            'assigned_to' => 'nullable|exists:users,id',
            'admin_notes' => 'nullable|string',
            'resolution'  => 'nullable|string',
        ]);

        $old = $feedback->status;

        if ($data['status'] === 'assigned' && !empty($data['assigned_to'])) {
            $data['assigned_at'] = now();
        }

        if ($data['status'] === 'resolved') {
            $data['resolved_at'] = now();
        }

        $feedback->update($data);
        AuditLog::record('update', "Updated feedback status: {$old} → {$data['status']}", $feedback);

        return redirect()->route('admin.feedback.show', $feedback)->with('success', 'Status updated.');
    }

    public function addResponse(Request $request, Feedback $feedback)
    {
        $data = $request->validate([
            'message'     => 'required|string',
            'is_internal' => 'nullable|boolean',
        ]);

        $data['user_id']     = auth()->id();
        $data['is_internal'] = $request->boolean('is_internal');

        $feedback->responses()->create($data);

        return redirect()->route('admin.feedback.show', $feedback)->with('success', 'Response added.');
    }

    public function destroy(Feedback $feedback)
    {
        AuditLog::record('delete', "Deleted feedback: {$feedback->reference_number}", $feedback);
        $feedback->delete();
        return redirect()->route('admin.feedback.index')->with('success', 'Feedback deleted.');
    }
}
