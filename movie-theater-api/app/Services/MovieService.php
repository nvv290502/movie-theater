<?php

namespace App\Services;

use App\Exceptions\InvalidNumbericException;
use App\Exceptions\ObjectEmptyException;
use App\Exceptions\ObjectExistsException;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use App\Repositories\Movie\MovieRepositoryInterface;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class MovieService
{
    protected $movieRepositoryInterface;
    protected $imageService;

    public function __construct(MovieRepositoryInterface $movieRepositoryInterface, ImageService $imageService)
    {
        $this->movieRepositoryInterface = $movieRepositoryInterface;
        $this->imageService = $imageService;
    }

    public function getAll($size, $isEnabled)
    {
        if (!is_numeric($size) || $size < 0) {
            throw new InvalidNumbericException("size phải là một số nguyên lớn hơn 0");
        }

        if (empty($isEnabled)) {
            return $this->movieRepositoryInterface->getAll($size);
        }
        return $this->movieRepositoryInterface->getAllIsEnabled($size, $isEnabled);
    }

    public function getById($id)
    {
        $movie =  $this->movieRepositoryInterface->getById($id);

        if (empty($movie)) {
            throw new ObjectEmptyException('Không có phim nào có id là ' . $id);
        }
        return $movie;
    }

    public function create(MovieRequest $movieRequest)
    {
        $movie = null;
        DB::transaction(function () use ($movieRequest, &$movie) {

            if($this->movieRepositoryInterface->existsMovie($movieRequest->name)){
                throw new ObjectExistsException('Phim da ton tai');
            }

            $imagePathPoster = $this->imageService->imageUpload($movieRequest->file('poster'));
            $imagePathBanner = $this->imageService->imageUpload($movieRequest->file('banner'));

            $request = $movieRequest->all();
            $request['poster'] = $imagePathPoster;
            $request['banner'] = $imagePathBanner; 

            $movie = $this->movieRepositoryInterface->create($request);

            $movie->categories()->attach($movieRequest->categoryIds);
        });

        return $movie;
    }

    public function update(MovieRequest $movieRequest, $id)
    { 
        $movie = Movie::find($id);

        if (empty($movie)) {
            throw new ObjectEmptyException('Không có phim nào có id là ' . $id);
        }

        $movie = null;
        DB::transaction(function () use ($movieRequest, &$movie, &$id) {

            if($this->movieRepositoryInterface->existsMovie($movieRequest->name)){
                throw new ObjectExistsException('Phim da ton tai');
            }

            $imagePathPoster = $this->imageService->imageUpload($movieRequest->file('poster'));
            $imagePathBanner = $this->imageService->imageUpload($movieRequest->file('banner'));

            $request = $movieRequest->validated();
            $request['poster'] = $imagePathPoster;
            $request['banner'] = $imagePathBanner; 

            $movie = $this->movieRepositoryInterface->update($request, $id);

            $movie->categories()->sync($movieRequest->categoryIds);
        });

        return $movie; 

    }

    public function isEnabled($id)
    {

        $movie = Movie::find($id);

        if (empty($movie)) {
            throw new ObjectEmptyException('Không có phim nào có id là ' . $id);
        }

        $this->movieRepositoryInterface->isEnabled($movie);

        return $movie;
    }

    public function getUpcomingMovie(){
        $movies = $this->movieRepositoryInterface->getUpcomingMovie();

        if(count($movies) <= 0){
            throw new ObjectEmptyException('Khong co phim nao sap chieu');
        }

        return $movies;
    }
}
