<?php

namespace App\Services\Visit;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\visit;

class VisitService
{
    /**
     * Create a new visit.
     *
     * @param array $data
     * @return \App\Models\visit
     */

    public function createVisit(array $data): visit
    {
        return Visit::create($data);
    }

    public function getVisitById(int $id): visit
    {
        return Visit::findOrFail($id);
    }

    /**
     * Get paginated visits.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
   public function getPaginatedVisits($perPage = 15)
    {
        return Visit::paginate($perPage);
    }

    public function updateVisit(visit $visit, array $data): visit
    {
        $visit->update($data);
        return $visit;
    }

    public function deleteVisit(visit $visit): bool
    {
        return $visit->delete();
    }
}