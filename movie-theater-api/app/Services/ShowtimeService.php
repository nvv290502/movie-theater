<?php

namespace App\Services;

use App\Exceptions\InvalidInputException;

class ShowtimeService
{
    protected $showtimeService;

    public function __construct(ShowtimeService $showtimeService)
    {
        $this->showtimeService = $showtimeService;
    }
    public function getShowtimeByMovie($movieId)
    {
        if(empty($movieId)){
            throw new InvalidInputException('Ban chua nhap id');
        }
        return $this->showtimeService->getShowtimeByMovie($movieId);
    }
}