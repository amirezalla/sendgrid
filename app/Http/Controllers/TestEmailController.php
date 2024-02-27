<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\TestEmail;
use App\Services\SendGridService;
use SendGrid\Mail\Footer;
use SendGrid\Mail\Mail;
use SendGrid\Mail\MailSettings;










class TestEmailController extends Controller
{
    public function send(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'message' => 'required',
            'from' => 'required|email',
            'from_name' => 'required',
            'subject' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $inputs = $validator->validated();
        $emailHtmlContent = view('emails.engine', ['message' => $inputs['message']])->render();

        $email = new Mail();
        $email->setFrom($inputs['from'], $inputs['from_name']);
        $email->setSubject($inputs['subject']);
        $email->addTo($inputs['to'], $inputs['to']);
        $email->addContent(
            "text/html", $emailHtmlContent
        );
        $footer = new Footer();
        $footer->setEnable(false);
        $mail_settings = new MailSettings();
        $mail_settings->setFooter($footer);
        $sendgrid = new \SendGrid(getenv('MAIL_PASSWORD'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }



    
    }

    public function apiTest(){

        return response()->json(['message' => 'api sent successfully']);


    }
}