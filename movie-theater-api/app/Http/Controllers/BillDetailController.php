<?php

namespace App\Http\Controllers;

use App\Services\BillDetailService;
use Illuminate\Http\Request;

class BillDetailController extends Controller
{
    protected $billDetailService;

    public function __construct(BillDetailService $billDetailService)
    {
        $this->billDetailService = $billDetailService;
    }
    public function getBillDetail($billCode)
    {
        $billDetail = $this->billDetailService->getBillDetail($billCode);

        if(count($billDetail) > 0){
            return response()->json([
                'status' => 200,
                'message' => 'Danh sach hoa don',
                'data' => $billDetail
            ]); 
        }
        return response()->json([
            'status' => 204,
            'message' => 'Khong co hoa don nao',
        ],200); 
    }
}
