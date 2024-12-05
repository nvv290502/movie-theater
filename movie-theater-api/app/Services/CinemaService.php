<?php

namespace App\Services;

use App\Exceptions\InvalidNumbericException;
use App\Exceptions\ObjectEmptyException;
use App\Exceptions\ObjectExistsException;
use App\Http\Requests\CinemaRequest;
use App\Models\Cinema;
use App\Models\Movie;
use App\Repositories\Cinema\CinemaRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CinemaService
{
    protected $cinemaRepositoryInterface;
    protected $imageService;

    public function __construct(CinemaRepositoryInterface $cinemaRepositoryInterface, ImageService $imageService)
    {
        $this->cinemaRepositoryInterface = $cinemaRepositoryInterface;
        $this->imageService = $imageService;
    }

    public function getAll($size, $isEnabled)
    {
        if (!is_numeric($size) || $size < 0) {
            throw new InvalidNumbericException("size phải là một số nguyên lớn hơn 0");
        }

        if (empty($isEnabled)) {
            return $this->cinemaRepositoryInterface->getAll($size);
        }
        return $this->cinemaRepositoryInterface->getAllIsEnabled($size, $isEnabled);
    }

    public function getById($id)
    {
        $cinema =  $this->cinemaRepositoryInterface->getById($id);

        if (empty($cinema)) {
            throw new ObjectEmptyException('Không có rap nào có id là ' . $id);
        }
        return $cinema;
    }

    public function create(CinemaRequest $cinemaRequest)
    {
        $cinema = null;
        DB::transaction(function () use ($cinemaRequest, &$cinema) {

            if ($this->cinemaRepositoryInterface->existsCinema($cinemaRequest->name, null)) {
                throw new ObjectExistsException('Rap da ton tai');
            }

            $imagePath = $this->imageService->imageUpload($cinemaRequest->file('cinema_image'));

            $request = $cinemaRequest->all();
            $request['cinema_image'] = $imagePath;

            $cinema = $this->cinemaRepositoryInterface->createOrUpdate($request, null);
        });

        return $cinema;
    }

    public function update(CinemaRequest $cinemaRequest, $id)
    {
        $cinema = Cinema::find($id);

        if(empty($cinema)){
            throw new ObjectEmptyException('Không có rap nào có id là ' . $id);
        }
        DB::transaction(function () use ($cinemaRequest, &$cinema, &$id) {

            if ($this->cinemaRepositoryInterface->existsCinema($cinemaRequest->name, $id)) {
                throw new ObjectExistsException('Rap da ton tai');
            }

            $imagePath = $this->imageService->imageUpload($cinemaRequest->file('cinema_image'));

            $request = $cinemaRequest->all();
            $request['cinema_image'] = $imagePath;

            $cinema = $this->cinemaRepositoryInterface->createOrUpdate($request, $id);
        });

        return $cinema;
    }

    public function isEnabled($id)
    {
        $cinema = Cinema::find($id);

        if (empty($cinema)) {
            throw new ObjectEmptyException('Không có rap nào có id là ' . $id);
        }

        $this->cinemaRepositoryInterface->isEnabled($cinema);

        return $cinema;
    }

    public function getCinemaByMovieShowtime($movieId, $city, $showDate)
    {

        if(empty(Movie::find($movieId))){
            throw new ObjectEmptyException('Ban chua nhap id hoac id khong ton tai');
        }
        return $this->cinemaRepositoryInterface->getCinemaByMovieShowTime($movieId, $city, $showDate);
    }
}
