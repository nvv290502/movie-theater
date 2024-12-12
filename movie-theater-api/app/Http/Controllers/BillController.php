<?php

namespace App\Http\Controllers;

use App\Services\BillService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    protected $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }
    public function saveBill(Request $request)
    {
        $bill = $this->billService->saveBill($request['billCode'], $request['userId'], $request['movieId'], $request['roomId'], $request['showDate'], $request['showTime'], $request['seats'], $request['price']);

        return response()->json([
            'status' => 201,
            'message' => 'Luu hoa don thanh cong',
            'data' => $bill
        ]);
    }
}
