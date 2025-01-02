<?php

namespace App\Services;

use App\Repositories\Bill\BillRepository;
use App\Repositories\Cinema\CinemaRepository;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;

use function PHPSTORM_META\map;

class RevenueService
{
    protected $billRepository;
    protected $movieRepository;
    protected $cinemaRepository;
    protected $userRepository;

    public function __construct(
        BillRepository $billRepository,
        MovieRepository $movieRepository,
        CinemaRepository $cinemaRepository,
        UserRepository $userRepository
    ) {
        $this->billRepository = $billRepository;
        $this->movieRepository = $movieRepository;
        $this->cinemaRepository = $cinemaRepository;
        $this->userRepository = $userRepository;
    }

    public function getYearRevenue()
    {
        return $this->billRepository->getYearRevenue();
    }

    public function getMonthRevenue($year)
    {
        $monthRevenue = [];
        $result = $this->billRepository->getMonthRevenue($year)->toArray();

        for($i = 1; $i < 13; $i++){
            if(array_key_exists($i, $result)){
                $monthRevenue[$i-1] = [
                    'month' => $i,
                    'revenues' => $result[$i]
                ];
            }else{
                $monthRevenue[$i-1] = [
                    'month' => $i,
                    'revenues' => 0
                ];
            }
        }
        return $monthRevenue;
    }

    public function getDailyRevenue($year, $month)
    {
        $dayInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $dayRevenue = [];
        $result = $this->billRepository->getDailyRevenue($year, $month)->toArray();
        for ($i = 1; $i <= $dayInMonth; $i++) {
            if(array_key_exists($i, $result)){
                $dayRevenue[$i-1] = [
                    'days' => $i,
                    'revenues' => $result[$i]
                ];
            }else{
                $dayRevenue[$i-1] = [
                    'days' => $i,
                    'revenues' => 0
                ];
            }
        }

        return $dayRevenue;
    }

    public function getHourRevenue($year, $month, $day)
    {
        $hourseRevenue = [];
      
        $result = $this->billRepository->getHoursRevenue($year, $month, $day)->toArray();

        for ($i = 1; $i <= 24; $i++) {

            if(array_key_exists($i, $result)){
                $hourseRevenue[$i-1] = [
                    'hours' => $i,
                    'revenues' => $result[$i]
                ];
            }else {
                $hourseRevenue[$i-1] = [
                    'hours' => $i,
                    'revenues' => 0
                ];
            }
        }

        return $hourseRevenue;
    }

    public function movieRevenue($startDate, $endDate)
    {
        $revenueMovie = [];

        $movies = $this->movieRepository->getMovieNameAndIds()->toArray();
        $result = $this->movieRepository->movieRevenue($startDate, $endDate);
        $result = $result->keyBy('movieId')->toArray();

        for($i = 1; $i <= count($movies); $i++){
            if(array_key_exists($i, $result)){
                $revenueMovie[$i-1] = [
                    'movieId' => $result[$i]['movieId'],
                    'movieName' => $result[$i]['movieName'],
                    'amountMoney' => ($result[$i]['amountMoney'] != null) ? $result[$i]['amountMoney'] : 0,
                    'numberTicket' => $result[$i]['numberTicket']
                ];
            }else{
                $revenueMovie[$i-1] = [
                    'movieId' => $movies[$i-1]->movieId,
                    'movieName' => $movies[$i-1]->movieName,
                    'amountMoney' => 0,
                    'numberTicket' => 0
                ];
            }
        }

        usort($revenueMovie, function ($a, $b) {
            return $b['amountMoney'] <=> $a['amountMoney'];
        });

        return collect($revenueMovie);
    }

    public function cinemaRevenue($startDate, $endDate)
    {
        $result = $this->cinemaRepository->revenueCinema($startDate, $endDate);

        foreach ($result as $item) {
            if ($item['amountMoney'] == null) {
                $item['amountMoney'] = 0;
            }
        }
        return $result;
    }

    public function getTopMovie()
    {
        $movieSales = $this->movieRepository->getTop10movieByNumberTicket();
        $movieRatings = $this->movieRepository->getTop10movieByRating();

        $maxSales = $movieSales->max('numberTicket') ?: 1;
        $maxRating = $movieRatings->max('rating') ?: 1.0;

        $salesMap = $movieSales->pluck('numberTicket', 'movieId')->toArray();
        $ratingMap = $movieRatings->pluck('rating', 'movieId')->toArray();

        $allMovieIds = collect($salesMap)->keys()->merge(collect($ratingMap)->keys())->unique();

        $hotScoreMap = [];
        foreach ($allMovieIds as $movieId) {
            $sales = $salesMap[$movieId] ?? 0;
            $rating = $ratingMap[$movieId] ?? 0.0;

            $normalizedSales = $sales > 0 ? log($sales + 1) / log($maxSales + 1) : 0;
            $normalizedRating = $rating > 0 ? $rating / $maxRating : 0;

            $hotScore = (0.6 * $normalizedSales) + (0.4 * $normalizedRating);
            $hotScoreMap[$movieId] = round($hotScore * 10, 2);
        }

        arsort($hotScoreMap);

        return array_slice($hotScoreMap, 0, 10, true);
    }

    public function getNewCustomer()
    {
        $endDate = Carbon::today()->addDay()->format('Y-m-d');
        $startDate = Carbon::today()->subDays(8)->format('Y-m-d');

        return $this->userRepository->getNewCustomer($startDate, $endDate);
    }
}
