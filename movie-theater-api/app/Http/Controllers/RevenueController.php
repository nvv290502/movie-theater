<?php

namespace App\Http\Controllers;

use App\Services\RevenueService;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    protected $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        $this->revenueService = $revenueService;
    }

    public function getYearRevenue()
    {
        $result = $this->revenueService->getYearRevenue();

        return $result;
    }

    public function getMonthRevenue(Request $request)
    {
        $result = $this->revenueService->getMonthRevenue($request['year']);

        return $result;
    }

    public function getDailyRevenue(Request $request)
    {
        $result = $this->revenueService->getDailyRevenue($request['year'], $request['month']);

        return $result;
    }

    public function getHoursRevenue(Request $request)
    {
        $result = $this->revenueService->getHourRevenue($request['year'], $request['month'], $request['day']);

        return $result;
    }
}
