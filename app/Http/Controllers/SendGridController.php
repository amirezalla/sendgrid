<?php

namespace App\Http\Controllers;

use App\Services\SendGridService;
use App\Services\DomainAuthenticationService;
use Illuminate\Http\Request;

class SendGridController extends Controller
{
    public function createSender(Request $request)
    {
        $sendGridService = new SendGridService(env('MAIL_PASSWORD'));

        $name=$request->name;
        $email=$request->email;

        $senderData = [
            'nickname' => $name,
            'from' => [
                'email' => $email,
                'name' => $name
            ],
            'reply_to' => [
                'email' => 'replyto_address@example.com',
                'name' => 'Reply to Name'
            ],
            'address' => '123 Elm St.',
            'city' => 'Denver',
            'state' => 'CO',
            'zip' => '80123',
            'country' => 'United States'
        ];


        $response = $sendGridService->createSenderIdentity($senderData);
        if($response){
            $domain=$this->extractDomainFromEmail($email);
            if(!$sendGridService->checkIfDomainAuthenticated($domain)){
                $sendGridService->createSenderAuthenticationDomain($domain,$email);
            } 
            return response()->json(['success' => true, 'response' => $response]);
        }else{
            return response()->json(['success' => false, 'response' => 'failed']);
        }

    }


    private function extractDomainFromEmail($email)
    {
        // Check if the email contains '@' symbol
        if(strpos($email, '@') !== false) {
            // Split the email by '@' and return the part after it
            $parts = explode('@', $email);
            return $parts[1]; // Return the domain part
        }
        
        // Return an empty string if '@' is not found in the email
        return '';
    }
}
