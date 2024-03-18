<?php

namespace App\Http\Controllers;

use App\Services\SendGridService;
use App\Services\DomainAuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SendGridController extends Controller
{
    public function createSender(Request $request)
    {
        $sendGridService = new SendGridService(getenv('MAIL_PASSWORD'));

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

    public static function addIpToAllowed(Request $request){
        $sendGridService = new SendGridService(getenv('MAIL_PASSWORD'));

        $response = $sendGridService->addIpToWhitelist($request->ip());
        if($response){
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


    public function getDomains(Request $request) {
        $sendGridService = new SendGridService(env('MAIL_PASSWORD'));
        $allDomains = $sendGridService->getDomains(); // Fetch all domains
    
        // Convert the domains to a collection if not already one
        $domainsCollection = collect($allDomains);
    
        // Define how many items you want to display per page
        $perPage = 10;
    
        // Use the current page requested by the user, default to 1
        $currentPage = $request->input('page', 1);
    
        // Slice the collection to get the items to display in current page
        $currentPageItems = $domainsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
    
        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($domainsCollection), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);
    
        return view('domains.all', ['data' => $paginatedItems]);
    }

    public function getSenders(){

        $sendGridService = new SendGridService(env('MAIL_PASSWORD'));
        $data = $sendGridService->getDomains();

        
        return view('domains.all', ['data'=>$data]);


    }


    public function webAddDomain(Request $request)
    {
        $sendGridService = new SendGridService(env('MAIL_PASSWORD'));
    
        // Mandatory fields
        $domain = $request->input('domain');
        $email = $request->input('email'); // Assuming this is also mandatory for notifications
    
        // Check domain authentication first
        if(!$sendGridService->checkIfDomainAuthenticated($domain)  || $sendGridService->checkIfDomainAuthenticated($domain)!='waiting' ){
            // Building the options array dynamically based on provided inputs
            $options = ['domain' => $domain];
    
            // Adding optional fields if they are present
            $optionalFields = ['subdomain', 'username', 'ips', 'custom_spf', 'default', 'automatic_security', 'custom_dkim_selector'];
            foreach ($optionalFields as $field) {
                if ($request->filled($field)) {
                    // For 'ips', assuming it's provided as a string and needs to be an array
                    $options[$field] = $field === 'ips' ? explode(',', $request->input($field)) : $request->input($field);
                }
            }
    
            $response = $sendGridService->webCreateSenderAuthenticationDomain($options, $email);
    
            if ($response) {
                return redirect('/domains/list')->with('success', 'Domain authenticated successfully.');
            } else {
                return back()->with('error', 'Failed to authenticate the domain.')->withInput();
            }
        } else {
            return back()->with('warning', 'This domain already exists in the list.')->withInput();
        }
    }
    
}
