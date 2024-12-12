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

    public function saveShowtime(Request $request)
    {
        $showtime = $this->showtimeService->saveShowtime($request);

        return response()->json([
            'status' => 200,
            'message' => 'Luu lich thanh cong',
            'data' => $showtime
        ]);
    }

    public function updatePriceTicket()
    {
        $showtimeId = request()->get('showtimeId');
        $price = request()->get('price');

        $showtime = $this->showtimeService->updatePriceTicket($showtimeId, $price);

        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat gia ve thanh cong',
            'data' => $showtime
        ]);
    }

    public function getPriceTicket(Request $request)
    {
        $price = $this->showtimeService->getPriceTicket($request['movieId'], $request['showDate'], $request['showTime'], $request['roomId']);

        return response()->json([
            'status' => 200,
            'message' => 'Thong tin gia ve',
            'data' => $price
        ]);
    }
}
