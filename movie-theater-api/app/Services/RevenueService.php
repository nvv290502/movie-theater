<?php

namespace App\Services;

use App\Repositories\Bill\BillRepository;

class RevenueService{
    protected $billRepository;

    public function __construct(BillRepository $billRepository)
    {
        $this->billRepository = $billRepository;
    }

    public function getYearRevenue()
    {
        return $this->billRepository->getYearRevenue();
    }

    public function getMonthRevenue($year)
    {
        return $this->billRepository->getMonthRevenue($year);
    }

    public function getDailyRevenue($year, $month)
    {
        return $this->billRepository->getDailyRevenue($year, $month);
    }

    public function getHourRevenue($year, $month, $day)
    {
        return $this->billRepository->getHoursRevenue($year, $month, $day);
    }
}