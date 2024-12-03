<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Services\RoomService;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = request()->input("size", 5);
        $isEnabled = request()->get('isEnabled');
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách phong',
            'data' => $this->roomService->getAll($size, $isEnabled)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomRequest $request)
    {
        $room = $this->roomService->create($request);

        if (!empty($room)) {
            return response()->json([
                'status' => 201,
                'message' => 'Thêm mới phong thành công',
                'data' => $room
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = $this->roomService->getById($id);

        return response()->json([
            'status' => 200,
            'message' => 'Phong có id là ' . $id,
            'data' => $room
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomRequest $request, $id)
    {
        $room = $this->roomService->update($request, $id);

        if (!empty($room)) {
            return response()->json([
                'status' => 200,
                'message' => 'Cap nhat phong thành công',
                'data' => $room
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = $this->roomService->isEnabled($id);
        
        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat trang thai phong co id la ' . $id . ' thanh cong',
            'data' => $room
        ]);
    }

    public function getRoomByCinema($cinemaId)
    {
        $size = request()->get('size');
        $room = $this->roomService->getRoomByCinema($cinemaId, $size);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach phong cua rap ' .$cinemaId,
            'data' => $room
        ]);
    }
}
