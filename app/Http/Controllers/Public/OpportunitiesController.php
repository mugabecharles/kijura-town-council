<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class OpportunitiesController extends Controller
{
    public function tenders(Request $request)
    {
        $tenders = Tender::with('department')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%")
                ->orWhere('reference_number', 'like', "%{$request->search}%"))
            ->latest('published_date')
            ->paginate(10)->withQueryString();

        return view('public.opportunities.tenders', compact('tenders'));
    }

    public function tenderShow(Tender $tender)
    {
        $tender->load(['department', 'documents']);
        return view('public.opportunities.tender-show', compact('tender'));
    }

    public function vacancies(Request $request)
    {
        $vacancies = Vacancy::with('department')
            ->when($request->type,   fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest('published_date')
            ->paginate(10)->withQueryString();

        return view('public.opportunities.vacancies', compact('vacancies'));
    }

    public function vacancyShow(Vacancy $vacancy)
    {
        $vacancy->load(['department', 'attachments']);
        return view('public.opportunities.vacancy-show', compact('vacancy'));
    }
}
