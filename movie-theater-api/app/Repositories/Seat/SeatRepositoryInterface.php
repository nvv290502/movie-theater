<?php

namespace App\Repositories\Seat;

interface SeatRepositoryInterface
{
    public function findByRowNameAndColumnName($rowName, $columnName);
}