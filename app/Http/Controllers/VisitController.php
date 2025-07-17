<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\Visit\VisitService;
use App\Http\Requests\CreateVisitRequest;
use App\Http\Requests\UpdateVisitRequest;

class VisitController extends Controller
{
    public function __construct(protected VisitService $visitService) {}

    public function index()
    {
        $visits = $this->visitService->getAllVisits();
        return Inertia::render('Visits/Index', [
            'visits' => Visit::all()
        ]);
    }

    public function store(CreateVisitRequest $request)
    {
        // dd($request->all());
        $this->visitService->createVisit($request->validated());
        return redirect()->route('visits.index');
    }

    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        $this->visitService->updateVisit($visit, $request->validated());
        return redirect()->route('visits.index');
    }

    public function destroy(Visit $visit)
    {
        $this->visitService->deleteVisit($visit);
        return redirect()->route('visits.index');
    }
}
