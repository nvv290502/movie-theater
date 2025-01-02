<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchRequest;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
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
    public function index(FetchRequest $request)
    {
        $movie = $this->movieService->getAll($request['size'], $request['isEnabled']);

        // return apiResponse(new MovieCollection($movie), 'Lay danh sach phim thanh cong', 200);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sách phim',
            'data' => $movie,
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
                'data' => new MovieResource($movie)
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movie = $this->movieService->getById($id);

        return response()->json([
            'status' => 200,
            'message' => 'Phim có id là ' . $id,
            'data' => $movie->load('categories')
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
    public function destroy($id)
    {
        $movie = $this->movieService->isEnabled($id);
        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat trang thai phim co id la ' . $id . ' thanh cong',
            'data' => $movie
        ]);
    }

    public function getUpcomingMovie()
    {
        $movie = $this->movieService->getUpcomingMovie();

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach phim sap chieu',
            'data' => $movie
        ]);
    }

    public function movieShowToday()
    {
        $now = date('Y-m-d');
        $movie = $this->movieService->movieShowByDate($now);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach phim chieu hom nay',
            'data' => $movie
        ]);
    }

    public function getMovieRelated(Request $request)
    {
        $categoryIds = $request->get('categoryIds');

        $movie = $this->movieService->getMovieListCategoryIds($categoryIds);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach phim lien quan',
            'data' => $movie->load('categories')
        ]);
    }

    public function getMovieByShowTime(Request $request)
    {
        $showTime = $request->get('time');
        $showDate = $request->get('date');
        $cinemaId = $request->get('cinema_id');

        $movie = $this->movieService->getMovieByShowTime($showTime, $showDate, $cinemaId);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach phim theo suat chieu',
            'data' => $movie
        ]);
    }

    public function getListName()
    {
        $movieNames = $this->movieService->getListName();

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach ten the loai',
            'data' => $movieNames
        ]);
    }

    public function getByName($name)
    {
        $movie = $this->movieService->getByName($name);

        return response()->json([
            'status' => 200,
            'message' => 'Tim kiem phim thanh cong',
            'data' => $movie
        ]);
    }

    public function getMovieIsShowing()
    {
        $movie = $this->movieService->getMovieIsShowing();

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach phim dang phat hanh',
            'data' => $movie
        ]);
    }
}
