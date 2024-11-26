<?php

namespace App\Http\Controllers;

use App\Http\Requests\CinemaRequest;
use App\Services\CinemaService;
use Illuminate\Http\Request;

class CinemaController extends Controller
{

    protected $cinemaService;

    public function __construct(CinemaService $cinemaService)
    {
        $this->cinemaService = $cinemaService;
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
            'message' => 'Danh sách rap',
            'data' => $this->cinemaService->getAll($size, $isEnabled)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CinemaRequest $request)
    {
        $cinema = $this->cinemaService->create($request);

        if (!empty($cinema)) {
            return response()->json([
                'status' => 201,
                'message' => 'Thêm mới rap thành công',
                'data' => $cinema
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cinema = $this->cinemaService->getById($id);

        return response()->json([
            'status' => 200,
            'message' => 'Rap có id là ' . $id,
            'data' => $cinema
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CinemaRequest $request, string $id)
    {
        $cinema = $this->cinemaService->update($request, $id);

        if (!empty($cinema)) {
            return response()->json([
                'status' => 200,
                'message' => 'Cap nhat rap thành công',
                'data' => $cinema
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cinema = $this->cinemaService->isEnabled($id);

        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat trang thai rap co id la ' . $id . ' thanh cong',
            'data' => $cinema
        ]);
    }

    public function getCinemaByMovieShowtime()
    {
        $movieId = request()->get('movie');
        $city = request()->get('city') ?? null;
        $showDate = request()->get('date') ?? null;

        $cinema = $this->cinemaService->getCinemaByMovieShowtime($movieId, $city, $showDate);

        if (count($cinema) <= 0) {
            return response()->json([
                'status' => 204,
                'message' => 'Hien tai phim chua co suat chieu trong khung gio nay',
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Danh sach rap chieu phim co id la ' . $movieId . ' trong ngay ' . $showDate,
            'data' => $cinema
        ]);
    }
}
