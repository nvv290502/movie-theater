<?php

namespace App\Services;

use App\Exceptions\InvalidInputException;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Repositories\Bill\BillRepository;
use App\Repositories\BillDetail\BillDetailRepository;
use App\Repositories\Schedule\ScheduleRepository;
use App\Repositories\Seat\SeatRepositoryInterface;
use App\Repositories\Showtime\ShowtimeRepository;
use Illuminate\Support\Facades\DB;

class BillService
{

    protected $scheduleRepository;
    protected $seatRepositoryInterface;
    protected $billDetailRepository;
    protected $showTimeRepository;
    protected $billRespository;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        SeatRepositoryInterface $seatRepositoryInterface,
        BillDetailRepository $billDetailRepository,
        ShowtimeRepository $showTimeRepository,
        BillRepository $billRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->seatRepositoryInterface = $seatRepositoryInterface;
        $this->billDetailRepository = $billDetailRepository;
        $this->showTimeRepository = $showTimeRepository;
        $this->billRespository = $billRepository;
    }
    public function saveBill($billCode, $userId, $movieId, $roomId, $showDate, $showTime, $seats, $price)
    {
        DB::beginTransaction();
        try {
            $bill = new Bill();
            $bill->user_id = $userId;
            $bill->bill_code = $billCode;
            $bill->is_ticket_issued = 0;
            $bill->bill_status = 'UNPAID';
            $bill->save();

            $seatList = $this->convertStringToSeats($seats);

            $schedule = $this->scheduleRepository->getScheduleByMovieAndShowDateAndShowTime($movieId, $showDate, $showTime)->toArray();

            $showtime = $this->showTimeRepository->getShowtimeByRoomAndSchedule($roomId, $schedule['schedule_id'])->toArray();

            foreach ($seatList as $seat) {
                $foundSeat = $this->seatRepositoryInterface->findByRowNameAndColumnName($seat['row_name'], $seat['column_name'])->toArray();
                $billDetail = $this->billDetailRepository->getBillDetailByRoomBySeatBySchedule(
                    $showtime['schedule_room_id'],
                    $foundSeat['seat_id'],
                );

                if (!empty($billDetail)) {
                    return 'da co nguoi dat truoc ghe ' . $foundSeat['row_name'].$foundSeat['column_name'];
                }

                $billDetail = new BillDetail();
                $billDetail->bill_id = $bill->bill_id;
                $billDetail->seat_id = $foundSeat['seat_id'];
                $billDetail->schedule_room_id = $showtime['schedule_room_id'];
                $billDetail->price = ($foundSeat['type_seat'] == 'VIP') ? ($price + ($price * 0.3)) : $price;
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
            array_push($seatList, [
                'column_name' => $columnName,
                'row_name' => $rowName
            ]);
        }
        return $seatList;
    }

    public function deleteBill($billCode)
    {
        $bill = $this->billRespository->finBillByBillCode($billCode);
        $billDetails = $this->billDetailRepository->findBillDetailByBillId($bill->bill_id);
        $billDetails->delete();
        $bill->delete();

        return 'Xoa thanh cong hoa don co ma ' .$billCode;
    }
}
