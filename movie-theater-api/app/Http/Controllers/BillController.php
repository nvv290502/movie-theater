<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Services\BillService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    protected $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }
    public function saveBill(BillRequest $request)
    {
        $bill = $this->billService->saveBill($request['billCode'], $request['userId'], $request['movieId'], $request['roomId'], $request['showDate'], $request['showTime'], $request['seats'], $request['price']);

        if($bill instanceof Bill){
            return response()->json([
                'status' => 201,
                'message' => 'Luu hoa don thanh cong',
                'data' => $bill
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => $bill,
        ]);
    }

    public function deleteBill(Request $request)
    {
        $data = $this->billService->deleteBill($request['billCode']);

        return response()->json([
            'status' => 400,
            'message' => $data,
        ]);
    }
}
