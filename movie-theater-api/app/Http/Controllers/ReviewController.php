<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
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
    public function store(ReviewRequest $request)
    {

        $review = $this->reviewService->saveReview($request);

        if(empty($review)){
            return apiResponse(null,'Co loi khi create review', 500);
        }

        if($review == -1){
            return response()->json([
                'status' => 409,
                'message' => 'Ban chi co the danh gia 1 lan'
            ]);
        }
        return apiResponse($review, 'Create review thanh cong', 201);
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

    public function getMovieReviewInfo($movieId){
        $result = $this->reviewService->getMovieReviewInfo($movieId);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach review',
            'data' => $result
        ]);
    }

    public function getReviewByMovieOrUser(Request $request)
    {
        $review = $this->reviewService->getReviewByMovieOrByUser($request['movieId'],$request['userId'],$request['size']);

        return apiResponse($review, 'danh sach review', 200);
    }
}
