<?php

namespace App\Services;

use App\Exceptions\DateTimeFormatException;
use App\Exceptions\InvalidInputException;
use App\Exceptions\InvalidNumbericException;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use DateTime;

class ScheduleService
{
    protected $scheduleRepositoryInterface;

    public function __construct(ScheduleRepositoryInterface $scheduleRepositoryInterface)
    {
        $this->scheduleRepositoryInterface = $scheduleRepositoryInterface;
    }

    public function getScheduleByCinema($movieId, $city, $showDate, $cinemaId)
    {
        if(empty($movieId)){
            throw new InvalidInputException('vui long nhap movie id');
        }

        // if(!is_numeric($movieId) || !is_numeric($cinemaId)){
        //     throw new InvalidNumbericException('id nhap vao phai la so nguyen');
        // }

        // if(!$this->isValidDate($showDate, 'Y-m-d')){
        //     throw new DateTimeFormatException('Ngay phai co dinh dang d-m-y');
        // }

        return $this->scheduleRepositoryInterface->getScheduleByCinema($movieId, $city, $showDate, $cinemaId);
    }

    function isValidDate($date, $format)
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}