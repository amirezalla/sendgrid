<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\TestEmail;
use App\Services\SendGridService;

class TestEmailController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'message' => 'required',
            'address' => 'required|email',
            'subject' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $inputs = $validator->validated();

        try {
            Mail::to($inputs["to"])->send(new TestEmail($inputs)); 
            return response()->json(['message' => 'Email sent successfully']);
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send email, please try again later.'.$e->getMessage()], 500);
        }
    }

    public function apiTest(){

        return response()->json(['message' => 'api sent successfully']);


    }
}