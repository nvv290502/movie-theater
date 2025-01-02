<?php

namespace App\Repositories\Bill;

use App\Models\Bill;

class BillRepository
{
    // public function saveBill($billCode, $userId, $movieId, $roomId, $showDate, $showTime, $seats, $price)
    // {
    //     $bill = new Bill();
    //     $bill->user_id = $userId;
    //     $bill->price
    // }

    public function getYearRevenue()
    {
        $result = Bill::selectRaw('YEAR(bill_detail.created_at) as years, SUM(bill_detail.price) as revenues')
            ->join('bill_detail', 'bill_detail.bill_id', 'bills.bill_id')
            ->groupByRaw('YEAR(bill_detail.created_at)')
            ->orderByRaw('YEAR(bill_detail.created_at) ASC')
            ->get();
       return $result;
    }

    public function getMonthRevenue($year)
    {
        $result = Bill::selectRaw('MONTH(bill_detail.created_at) as month, SUM(bill_detail.price) as revenues')
            ->join('bill_detail', 'bill_detail.bill_id', 'bills.bill_id')
            ->whereYear("bill_detail.created_at", $year)
            ->groupByRaw('MONTH(bill_detail.created_at)')
            ->orderByRaw('MONTH(bill_detail.created_at) ASC')
            ->pluck('revenues', 'month');
        return $result;
    }

    public function getDailyRevenue($year, $month)
    {
        $result = Bill::selectRaw('DAY(bill_detail.created_at) as days, SUM(bill_detail.price) as revenues')
            ->join('bill_detail', 'bill_detail.bill_id', 'bills.bill_id')
            ->whereYear("bill_detail.created_at", $year)
            ->whereMonth("bill_detail.created_at", $month)
            ->groupByRaw('DAY(bill_detail.created_at)')
            ->orderByRaw('DAY(bill_detail.created_at) ASC')
            ->pluck('revenues', 'days');
        return $result;
    }

    public function getHoursRevenue($year, $month, $day)
    {
        $result = Bill::selectRaw('HOUR(bill_detail.created_at) as hours, SUM(bill_detail.price) as revenues')
            ->join('bill_detail', 'bill_detail.bill_id', 'bills.bill_id')
            ->whereYear("bill_detail.created_at", $year)
            ->whereMonth("bill_detail.created_at", $month)
            ->whereDay("bill_detail.created_at", $day)
            ->groupByRaw('HOUR(bill_detail.created_at)')
            ->orderByRaw('HOUR(bill_detail.created_at) ASC')->pluck('revenues', 'hours');
        return $result;
    }

    public function finBillByBillCode($billCode)
    {
        return Bill::where($billCode)->first();
    }
}
