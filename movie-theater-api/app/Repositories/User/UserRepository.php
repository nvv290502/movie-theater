<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function getAmountMoney($userId)
    {
        return DB::table('bills as b')
            ->join('bill_detail as bd', 'bd.bill_id', 'b.bill_id')
            ->where('b.user_id', $userId)
            ->where('b.status', 'PAID')
            ->selectRaw('SUM(bd.price) as amount')
            ->groupBy('b.user_id')
            ->get();
    }

    public function getHistoryBill($userId, $date, $billCode)
    {
        return DB::table('bills as b')
            ->join('bill_detail as bd', 'b.bill_id', '=', 'bd.bill_id')
            ->join('schedules as sch', 'sch.schedule_id', '=', 'bd.schedule_id')
            ->join('schedule_room as sr', 'sr.schedule_id', '=', 'sch.schedule_id')
            ->join('rooms as r', 'r.room_id', '=', 'sr.room_id')
            ->join('movies as m', 'm.movie_id', '=', 'sch.movie_id')
            ->when($userId, function ($query, $userId) {
                $query->where('b.user_id', $userId);
            })
            ->when($date, function ($query, $date) {
                $query->where('sch.schedule_date', $date);
            })
            ->when($billCode, function ($query, $billCode) {
                $query->where('b.bill_code', $billCode);
            })
            ->select(
                'b.bill_code',
                'm.movie_name',
                'm.movie_id',
                'b.user_id',
                'm.duration',
                'r.room_name',
                'sch.schedule_date',
                'sch.schedule_time',
                DB::raw('SUM(bd.price) as amountMoney'),
                'b.created_at',
                'b.status',
                'b.isTicketIssued'
            )
            ->groupBy(
                'b.bill_code',
                'm.movie_name',
                'm.movie_id',
                'b.user_id',
                'm.duration',
                'r.room_name',
                'sch.schedule_date',
                'sch.schedule_time',
                'b.created_at',
                'b.status',
                'b.isTicketIssued'
            )
            ->get();
    }

    public function getNewCustomer($startTime, $endTime)
    {
        return User::whereHas('roles', function ($query) {
            $query->where('role_name', 'ROLE_USER');
        })
        ->where('is_confirm', 1)
        ->where('is_enabled', 1)
        ->whereBetween('created_at', [$startTime, $endTime])
        ->distinct()
        ->get();
    }
    
}
