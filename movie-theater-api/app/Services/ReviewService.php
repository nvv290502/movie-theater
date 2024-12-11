<?php

namespace App\Services;

use App\Exceptions\ObjectEmptyException;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Repositories\Review\ReviewRepository;

class ReviewService
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function getMovieReviewInfo($movie)
    {
        $reviews = $this->reviewRepository->getReviewByMovie($movie);

        if (empty($reviews)) {
            throw new ObjectEmptyException("Phim chua co danh gia");
        }

        $ratings = [];
        $comments = [];

        foreach ($reviews as $value) {
            if ($value->number_star != null) {
                array_push($ratings, $value->number_star);
            }
            if ($value->comment != null && !empty($value->comment)) {
                array_push($comments, $value->comment);
            }
        }

        $averageRating = collect($ratings)->average() ?? 0.0;

        $formattedAverageRating = number_format($averageRating, 1);

        $commentCount = count($comments);
        $countRating = count($ratings);

        $reviews = Review::all(); // Lấy tất cả đánh giá

        $ratingCounts = $reviews->groupBy('number_star')
            ->map(fn($group) => $group->count());

        return [
            'movieId' => $movie,
            'rating' => $formattedAverageRating,
            'countComment' => $commentCount,
            'countRating' => $countRating,
            'ratingCounts' => $ratingCounts
        ];
    }

    public function saveReview(ReviewRequest $request)
    {
        $exists = $this->reviewRepository->existsByReview($request['movieId'], $request['userId']);
        if($exists){
            return -1;
        } 
        return $this->reviewRepository->saveReview($request);
    }

    public function getReviewByMovieOrByUser($movieId, $userId, $size)
    {
        return $this->reviewRepository->getReviewByMovieOrByUser($movieId, $userId, $size);
    }
}
