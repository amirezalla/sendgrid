<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\TestEmail;

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

        dd(env('MAIL_PASSWORD'));
        Mail::to($inputs["to"])->send(new TestEmail($inputs)); 

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function apiTest(){

        return response()->json(['message' => 'api sent successfully']);


    }
}