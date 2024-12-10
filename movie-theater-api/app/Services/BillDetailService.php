<?php

namespace App\Services;

use App\Exceptions\ObjectEmptyException;
use App\Http\Resources\BillDetailCollection;
use App\Models\RoomSeat;
use App\Repositories\BillDetail\BillDetailRepository;

class BillDetailService{

    protected $billDetailRepository;

    public function __construct(BillDetailRepository $billDetailRepository)
    {
        $this->billDetailRepository = $billDetailRepository;
    }

    public function getBillDetail($billCode){
        return $this->billDetailRepository->getBillDetail($billCode);
    }
}