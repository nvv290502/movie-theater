<?php


namespace App\Repositories\Schedule;

use Illuminate\Http\Request;

interface ScheduleRepositoryInterface
{
    public function getScheduleByCinema($movieId, $city, $showDate, $cinemaId);
    public function getScheduleByMoviAndShowdateAndShowtime($movieId, $showDate, $showTime);
    public function findByRoomId($roomId);
    public function countTicketBySchedule($scheduleId);
    public function getScheduleByRoom($roomId);
    public function saveOrUpdate(Request $request);
    public function checkExistsSchedule(Request $request);
    public function getExistsSchedule(Request $request);
    public function getListScheduleManager($size);
}