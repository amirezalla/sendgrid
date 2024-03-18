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
        // SendGridController::addIpToAllowed($request);

        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'message' => 'required',
            'address' => 'required|email',
            'name' => 'required',
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $inputs = $validator->validated();

        try {
            Mail::to($inputs["to"])->send(new TestEmail($inputs));
            return response()->json(['message' => 'Email sent successfully']);
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }

    public function sendBatch(Request $request)
    {
        // SendGridController::addIpToAllowed($request);
        $validator = Validator::make($request->all(), [
            'to' => 'required', // Validation for 'to' as a string, further validation happens below
            'message' => 'required',
            'address' => 'required|email',
            'name' => 'required',
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $inputs = $validator->validated();

        // Split the 'to' string into an array of email addresses
        $recipients = explode(',', $inputs['to']); // Assuming comma as the delimiter

        // Filter out invalid email addresses
        $validRecipients = array_filter($recipients, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        if (empty($validRecipients)) {
            return response()->json(['error' => 'No valid email addresses provided'], 422);
        }

        // Attempt to send an email to each recipient
        foreach ($validRecipients as $recipient) {
            try {
                // Update 'to' in $inputs for the current recipient
                $inputs['to'] = $recipient;
                Mail::to($recipient)->send(new TestEmail($inputs));
            } catch (Exception $e) {
                // Log error or handle individual email send failure
                Log::error('Failed to send email to ' . $recipient . ': ' . $e->getMessage());
            }
        }

    return response()->json(['message' => 'Emails sent successfully to valid recipients']);
}
    public function sendEmail(Request $request){
        $subject = $request->input('subject');
        $message = $request->input('message');
        $from = $request->input('from');

        $emailHtmlContent = view('emails.engine', ['message' => $message])->render();


        $recipients = explode(',', $request->input('recipients'));
        foreach($recipients as $to){
            $email = new Mail();
            $email->setFrom($from, $from);
            $email->setSubject($subject);
            $email->addTo($to, $to);
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
     
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
        }

        return  redirect('/mail/send')->with('success', 'Email sent successfully!');
        

    }



    public function apiTest(){

        return response()->json(['message' => 'api sent successfully']);


    }
}
