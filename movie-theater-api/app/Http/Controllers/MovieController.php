<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Services\ImageService;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
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
            'message' => 'Danh sách phim',
            'data' => $this->movieService->getAll($size, $isEnabled)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        $movie = $this->movieService->create($request);

        if (!empty($movie)) {
            return response()->json([
                'status' => 201,
                'message' => 'Thêm mới phim thành công',
                'data' => $movie->load('categories')
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = $this->movieService->getById($id);

        return response()->json([
            'status' => 200,
            'message' => 'Phim có id là ' . $id,
            'data' => $movie
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieRequest $request, $id)
    {
        $movie = $this->movieService->update($request, $id);

        if (!empty($movie)) {
            return response()->json([
                'status' => 200,
                'message' => 'Cap nhat phim thành công',
                'data' => $movie->load('categories')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = $this->movieService->isEnabled($id);
        
        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat trang thai phim co id la ' . $id . ' thanh cong',
            'data' => $movie
        ]);
    }

    public function getUpcomingMovie(){
        $movie = $this->movieService->getUpcomingMovie();

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach phim sap chieu',
            'data' => $movie
        ]);
    }
}
