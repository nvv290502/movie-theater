<?php

namespace App\Services;

use App\Repositories\Bill\BillRepository;
use App\Repositories\Cinema\CinemaRepository;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;

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

        for($i = 1; $i < 13; $i++){
            array_push($monthRevenue, [
                'month' => $i,
                'revenues' => 0
            ]);
        }

        $result = $this->billRepository->getMonthRevenue($year)->toArray();

        foreach ($monthRevenue as &$item1) {
            foreach ($result as $item2) {
                if ($item1['month'] === $item2['month']) {
                    $item1['revenues'] = $item2['revenues'];
                }
            }
        }

        return $monthRevenue;
    }

    public function getDailyRevenue($year, $month)
    {
        $dayInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $dayRevenue = [];
        for ($i = 1; $i <= $dayInMonth; $i++) {
            array_push($dayRevenue, [
                "days" => $i,
                "revenues" => 0
            ]);
        }

        $result = $this->billRepository->getDailyRevenue($year, $month)->toArray();

        foreach ($dayRevenue as &$item1) {
            foreach ($result as $item2) {
                if ($item1['days'] === $item2['days']) {
                    $item1['revenues'] = $item2['revenues'];
                }
            }
        }
        return $dayRevenue;
    }

    public function getHourRevenue($year, $month, $day)
    {
        $hourseRevenue = [];

        for ($i = 1; $i <= 24; $i++) {
            array_push($hourseRevenue, [
                'hours' => $i,
                'revenues' => 0
            ]);
        }

        $result = $this->billRepository->getHoursRevenue($year, $month, $day)->toArray();

        foreach ($hourseRevenue as &$item1) {
            foreach ($result as $item2) {
                if ($item1['hours'] === $item2['hours']) {
                    $item1['revenues'] = $item2['revenues'];
                }
            }
        }
        return $hourseRevenue;
    }

    public function movieRevenue($startDate, $endDate)
    {
        $result = $this->movieRepository->movieRevenue($startDate, $endDate);

        foreach ($result as $item) {
            if ($item['amountMoney'] == null) {
                $item['amountMoney'] = 0;
            }
        }
        return $result;
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
