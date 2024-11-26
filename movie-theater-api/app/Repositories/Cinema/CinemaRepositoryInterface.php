<?php

namespace App\Repositories\Cinema;

use App\Models\Cinema;

interface CinemaRepositoryInterface{
    public function getAll($size);
    public function getAllIsEnabled($size, $isEnabled);
    public function getById($id);
    public function createOrUpdate(array $request, $id);
    public function isEnabled(Cinema $cinema);
    public function existsCinema($cinemaName);
    public function getCinemaByMovieShowTime($movieId, $city, $showDate);
}
