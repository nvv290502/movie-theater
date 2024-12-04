<?php

namespace App\Http\Controllers;

use App\Services\RoomSeatService;
use App\Services\SeatService;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    protected $seatService;
    protected $roomSeatService;

    public function __construct(SeatService $seatService, RoomSeatService $roomSeatService)
    {
        $this->seatService = $seatService;
        $this->roomSeatService = $roomSeatService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function getSeatByRoom($roomId)
    {
        $seats = $this->seatService->getSeatByRoom($roomId);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach ghe phong có id là ' . $roomId,
            'data' => $seats
        ]);
    }

    public function updateStatusSeat($roomId, Request $request)
    {
        $this->roomSeatService->updateStatusSeat($roomId, $request);

        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat trang thai ghe thanh cong',
        ]);
    }
}
