<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function getAdminPage(){
        return response()->json([
            'status' => 200
        ], 200);
    }
}
