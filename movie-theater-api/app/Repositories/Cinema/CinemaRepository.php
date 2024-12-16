<?php

namespace App\Repositories\Cinema;

use App\Models\Cinema;
use App\Repositories\Cinema\CinemaRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CinemaRepository implements CinemaRepositoryInterface
{

    public function getAll($size)
    {
        return Cinema::query()->paginate($size);
    }

    public function getAllIsEnabled($size, $isEnabled)
    {
        return Cinema::where('is_enabled', $isEnabled)->paginate($size);
    }

    public function getById($id)
    {
        return Cinema::find($id);
    }

    public function createOrUpdate(array $request, $id)
    {
        $data = [
            'cinema_name' => $request['name'],
            'address' => $request['address'],
            'hotline' => $request['hotline'],
            'description' => $request['description'],
        ];

        if ($request['cinema_image']) {
            $data['cinema_image_url'] = $request['cinema_image'];
        }

        return Cinema::updateOrCreate(
            ['cinema_id' => $id],
            $data
        );
    }

    public function isEnabled(Cinema $cinema)
    {
        return $cinema->update(['is_enabled' => !$cinema->is_enabled]);
    }

    public function existsCinema($cinemaName, $id)
    {
        return Cinema::where('cinema_name', $cinemaName)
            ->when($id, function ($query, $id) {
                $query->where('cinema_id', '!=', $id);
            })
            ->exists();
    }

    public function getCinemaByMovieShowTime($movieId, $city = null, $showDate = null)
    {
        return DB::table('cinemas as c')
            ->join('rooms as r', 'c.cinema_id', 'r.cinema_id')
            ->join('schedule_room as sr', 'r.room_id', 'sr.room_id')
            ->join('schedules as sch', 'sch.schedule_id', 'sr.schedule_id')
            ->where('sch.movie_id', $movieId)
            ->where('sch.schedule_date', '>=', DB::raw('DATE(NOW())'))
            ->where('sch.schedule_time', '>=', DB::raw('TIME(NOW())'))
            ->when($city, function ($query, $city) {
                $query->where('c.address', 'like', '%' . $city . '%');
            })
            ->when($showDate, function ($query, $showDate) {
                $query->where('sch.schedule_date', $showDate);
            })
            ->select('c.*', 'sch.schedule_date', 'sch.schedule_time')
            ->distinct()
            ->get();
    }

    public function revenueCinema($startDate, $endDate)
    {
        $query =  Cinema::selectRaw('cinemas.cinema_id as cinemaId, cinemas.cinema_name as cinemaName, SUM(bill_detail.price) as amountMoney, COUNT(bill_detail.bill_id) as numberTicket')
            ->leftJoin('rooms', 'rooms.cinema_id', '=', 'cinemas.cinema_id')
            ->leftJoin('schedule_room', 'schedule_room.room_id', '=', 'rooms.room_id')
            ->leftJoin('bill_detail', 'bill_detail.schedule_room_id', '=', 'schedule_room.schedule_room_id')
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate){
                $query->whereBetWeen('bill_detail.created_at', [$startDate, $endDate]);
            })
            ->groupBy('cinemas.cinema_id', 'cinemas.cinema_name')
            ->orderBy('amountMoney','desc')
            ->get();
       return $query;
    }
}
