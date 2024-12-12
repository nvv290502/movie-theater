<?php

namespace App\Services;

use App\Exceptions\InvalidInputException;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Seat;
use App\Repositories\BillDetail\BillDetailRepository;
use App\Repositories\Schedule\ScheduleRepository;
use App\Repositories\Seat\SeatRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Http\Exceptions\InvalidData;

class BillService
{

    protected $scheduleRepository;
    protected $seatRepositoryInterface;
    protected $billDetailRepository;

    public function __construct(ScheduleRepository $scheduleRepository, SeatRepositoryInterface $seatRepositoryInterface, BillDetailRepository $billDetailRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->seatRepositoryInterface = $seatRepositoryInterface;
        $this->billDetailRepository = $billDetailRepository;
    }
    public function saveBill($billCode, $userId, $movieId, $roomId, $showDate, $showTime, $seats, $price)
    {
        DB::beginTransaction();

        try {
            $bill = new Bill();
            $bill->user_id = $userId;
            $bill->bill_code = $billCode;
            $bill->is_ticket_issued = 0;
            $bill->status = 'UNPAID';
            $bill->save();

            $seatList = $this->convertStringToSeats($seats);
            $schedule = $this->scheduleRepository->getScheduleByMovieAndShowDateAndShowTime($movieId, $showDate, $showTime);

            foreach ($seatList as $seat) {
                $foundSeat = $this->seatRepositoryInterface->findByRowNameAndColumnName($seat->row_name, $seat->column_name);

                $existsBillDetail = $this->billDetailRepository->getBillDetailByRoomBySeatBySchedule(
                    $roomId,
                    $foundSeat->seat_id,
                    $schedule->schedule_id
                );

                if ($existsBillDetail) {
                    throw new InvalidInputException('Da co nguoi dat truoc ban vi tri ghe '
                        . $foundSeat->row_name . $foundSeat->column_name);
                }

                $billDetail = new BillDetail();
                $billDetail->bill_id = $bill->bill_id;
                $billDetail->seat_id = $foundSeat->seat_id;
                $billDetail->room_id = $roomId;
                $billDetail->schedule_id = $schedule->schedule_id;
                $billDetail->price = $price;
                $billDetail->save();
            }

            DB::commit();

            return $bill;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function convertStringToSeats($seatString)
    {
        $seatList = [];
        $seatArray = explode(',', $seatString);

        foreach ($seatArray as $seat) {
            $rowName = substr($seat, 0, 1);
            $columnName = substr($seat, 1);

            $newSeat = new Seat();
            $newSeat->column_name = $columnName;
            $newSeat->row_name = $rowName;
            array_push($seatList, $newSeat);
        }
        return $seatList;
    }
}
