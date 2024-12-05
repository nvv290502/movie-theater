<?php

namespace App\Services;

use App\Exceptions\InvalidInputException;
use App\Repositories\Showtime\ShowtimeRepositoryInterface;
use Illuminate\Http\Request;

class ShowtimeService
{
    protected $showtimeRepositoryInterface;

    public function __construct(ShowtimeRepositoryInterface $showtimeRepositoryInterface)
    {
        $this->showtimeRepositoryInterface = $showtimeRepositoryInterface;
    }
    public function getShowtimeByMovie($movieId)
    {
        if(empty($movieId)){
            throw new InvalidInputException('Ban chua nhap id');
        }
        return $this->showtimeRepositoryInterface->getShowtimeByMovie($movieId);
    }

    public function saveShowtime(Request $request)
    {
        return $this->showtimeRepositoryInterface->saveShowtime($request);
    }
}