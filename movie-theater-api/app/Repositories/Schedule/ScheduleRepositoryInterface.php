<?php


namespace App\Repositories\Schedule;

interface ScheduleRepositoryInterface
{
    public function getScheduleByCinema($movieId, $city, $showDate, $cinemaId);
    public function getScheduleByMoviAndShowdateAndShowtime($movieId, $showDate, $showTime);
    public function findByRoomId($roomId);
    public function countTicketBySchedule($scheduleId);
    public function getScheduleByRoom($roomId);
}