<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function sendEmail()
    {
        $data = [
            'message' => 'Hello',
        ];

        Mail::to('nvv29052002@gmail.com')->send(new SendMail($data));

        return response()->json([
            'status' => 202,
            'message' => 'Email send successfully'
        ]);
    }
}
