<?php

namespace App\Services\Visit;

use App\Models\Visit;

class VisitService
{
    public function getAllVisits()
    {
        return Visit::orderBy('created_at', 'desc')->get();
    }

    public function getVisitById(int $id): Visit
    {
        return Visit::findOrFail($id);
    }

    public function createVisit(array $data): Visit
    {
        return Visit::create($data);
    }

    public function updateVisit(Visit $visit, array $data): Visit
    {
        $visit->update($data);
        return $visit;
    }

    public function deleteVisit(Visit $visit): bool
    {
        return $visit->delete();
    }
}
