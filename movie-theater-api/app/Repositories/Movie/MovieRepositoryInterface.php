<?php

namespace App\Repositories\Movie;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;

interface MovieRepositoryInterface
{
    public function getAll($size);
    public function getAllIsEnabled($size, $isEnabled);
    public function getById($id);
    public function create(array $request);
    public function update(array $request, $movie);
    public function isEnabled(Movie $movie);
    public function existsMovie($movieName, $id);
    public function getUpcomingMovie();
    public function movieShowByDate($date);
    public function getMovieListCategoryIds(array $categoryId);
    public function getMovieByShowTime($showTime, $showDate, $cinemaId);
    public function getListName();
    public function getByName($categoryName);
    public function getMovieIsShowing();
}