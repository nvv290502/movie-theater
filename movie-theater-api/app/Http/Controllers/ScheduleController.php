<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $scheduleSerive;

    public function __construct(ScheduleService $scheduleSerive)
    {
        $this->scheduleSerive = $scheduleSerive;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = request()->get('size');

        $result = $this->scheduleSerive->getListScheduleManager($size);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach lich chieu',
            'data' => $result
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $schedule = $this->scheduleSerive->saveOrUpdateSchedule($request);

        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat lich chieu thanh cong',
            'data' => $schedule
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getScheduleByCinema()
    {
        $movieId = request()->get('movie_id');
        $city = request()->get('city');
        $showDate = request()->get('date');
        $cinemaId = request()->get('cinema_id');

        $schedule = $this->scheduleSerive->getScheduleByCinema($movieId, $city, $showDate, $cinemaId);
        
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách suat chieu theo rap',
            'data' => $schedule
        ]);
    }

    public function getScheduleByRoom($roomId)
    {
        $result = $this->scheduleSerive->getScheduleByRoom($roomId);

        return response()->json([
            'status' => 200,
            'message' => 'Thong tin suat chieu theo phong',
            'data' => $result
        ]);
    }
}
