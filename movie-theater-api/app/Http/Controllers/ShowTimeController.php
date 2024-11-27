<?php

namespace App\Http\Controllers;

use App\Services\ShowtimeService;
use Illuminate\Http\Request;

class ShowTimeController extends Controller
{
    protected $showtimeService;

    public function __construct(ShowtimeService $showtimeService)
    {
        $this->showtimeService = $showtimeService;
    }

    public function getShowtimeByMovie($movieId)
    {
        $showtime = $this->showtimeService->getShowtimeByMovie($movieId);

        if(count($showtime) <= 0){
            return response()->json([
                'status' => 204,
                'message' => 'Khong co suat chieu nao',
            ], 200);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách suat chieu cua phim co id ' .$movieId,
            'data' => $showtime
        ]);
    }
}
