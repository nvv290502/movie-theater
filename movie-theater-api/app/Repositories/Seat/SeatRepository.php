<?php

namespace App\Repositories\Seat;

use App\Models\Seat;

class SeatRepository implements SeatRepositoryInterface
{
    public function findByRowNameAndColumnName($rowName, $columnName)
    {
        return Seat::where('row_name', $rowName)
        ->where('column_nam', $columnName)
        ->first();
    }
}