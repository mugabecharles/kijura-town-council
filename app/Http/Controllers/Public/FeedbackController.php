<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $categories  = FeedbackCategory::where('is_active', true)->get();
        $departments = Department::active()->orderBy('name')->get();
        return view('public.feedback.index', compact('categories', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'        => 'required|in:feedback,complaint,suggestion,service_request',
            'category_id' => 'nullable|exists:feedback_categories,id',
            'department_id'=> 'nullable|exists:departments,id',
            'subject'     => 'required|string|max:255',
            'message'     => 'required|string|max:5000',
            'name'        => 'required_unless:is_anonymous,1|nullable|string|max:255',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:500',
            'is_anonymous'=> 'nullable|boolean',
        ]);

        $data['is_anonymous']     = $request->boolean('is_anonymous');
        $data['reference_number'] = Feedback::generateReferenceNumber();
        $data['ip_address']       = $request->ip();
        $data['status']           = 'new';

        if ($data['is_anonymous']) {
            $data['name']  = 'Anonymous';
            $data['email'] = null;
            $data['phone'] = null;
        }

        $feedback = Feedback::create($data);

        return redirect()->route('feedback.thankyou', ['ref' => $feedback->reference_number])
            ->with('success', "Thank you! Your submission has been received with reference number {$feedback->reference_number}.");
    }

    public function thankyou(Request $request)
    {
        $ref = $request->get('ref');
        return view('public.feedback.thankyou', compact('ref'));
    }

    public function track(Request $request)
    {
        $feedback = null;
        if ($request->isMethod('post')) {
            $request->validate(['reference_number' => 'required|string']);
            $feedback = Feedback::where('reference_number', $request->reference_number)->first();
            if (!$feedback) {
                return redirect()->back()->with('error', 'No submission found with that reference number.');
            }
        }
        return view('public.feedback.track', compact('feedback'));
    }

    public function contact()
    {
        return view('public.feedback.contact');
    }
}
