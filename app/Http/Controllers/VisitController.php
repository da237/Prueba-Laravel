<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\CreateVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Services\Visit\VisitService;

class VisitController extends Controller
{

    public function __construct(protected VisitService $visitService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $visits = $this->visitService->getPaginatedVisits(); // se mantiene tu lógica de servicio

    return Inertia::render('Dashboard', [
        'visits' => $visits
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('visits.maps', ['visit' => new Visit()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateVisitRequest $request)
    {
        $this->visitService->createVisit($request->validated());
        return redirect()->route('visits.index')->with('success', 'Visit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(visit $visit)
    {
        $visit = $this->visitService->getVisitById($visit->id);
        return view('visits.maps', compact('visit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisitRequest $request, Visit $visit)
    {
        $this->visitService->updateVisit($visit, $request->validated());
        return redirect()->route('visits.index')->with('success', 'Visit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(visit $visit)
    {
        $this->visitService->deleteVisit($visit);
        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }
}
