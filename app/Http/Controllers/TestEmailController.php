<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\TestEmail;
use App\Mail\AlertEmail;

use App\Services\SendGridService;
use App\Models\Smtp;
use App\Models\Maillog;
use SendGrid\Mail\Footer;
use SendGrid\Mail\Mail;
use Illuminate\Support\Facades\Mail as LaravelMail;

use SendGrid\Mail\MailSettings;







class TestEmailController extends Controller
{
    public function send(Request $request)
    {

        $subject = $request->input('subject');
        $message = $request->input('message');
        $from = $request->input('from');

        $emailHtmlContent = $this->addFooterToContent($message);


        $recipients = explode(',', $request->input('recipients'));
        foreach($recipients as $to){
            $email = new Mail();
            $email->setFrom($from, $from);
            $email->setSubject($subject);
            $email->addTo($to, $to);
            $email->addContent(
                "text/html", $emailHtmlContent
            );
            // $footer = new Footer();
            // $footer->setEnable(false);
            // $mail_settings = new MailSettings();
            // $mail_settings->setFooter($footer);
            $sendgrid = new \SendGrid(getenv('MAIL_PASSWORD'));
            try {
                $parts = explode("@", $from);

                // The second part of the result is the domain
                $domain = $parts[1];
                $smtp=Smtp::where('domain',$domain)->first();
                if($smtp->usage >= $smtp->alert_number && !$smtp->alert_sent){
                    $smtp->alert_sent=1;
                    $smtp->save();
                    LaravelMail::to($smtp->alert)->send(new AlertEmail($smtp));
                }
                $response = $sendgrid->send($email);
                // Log the email sending action
                
                Maillog::create([
                    'recipient' => $to,
                    'subject' => $subject,
                    'sender' => $from,
                    'html'=>$emailHtmlContent,
                    'sent_at' => now(),
                    'via' => 'sendgrid'
                ]);

                print_r($response);

            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
        }

        return true;

    }

    private function addFooterToContent($message){

        return $message=$message.`
            <footer style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #EEE; text-align: center;">
                <p>The email has been sent by ICOA email engine</p>
            </footer> `;
        
    }

    public function sendBatch(Request $request)
    {
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
