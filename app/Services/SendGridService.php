<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendGridEmail;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;



class SendGridService
{
    protected $client;
    protected $apiKey;

    public function __construct($apiKey)
    {
            $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.sendgrid.com/',
        ]);
    }

    public function createSenderIdentity(array $senderData)
    {
        try {
            $response = $this->client->post('v3/marketing/senders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $senderData,
            ]);

            return $data = json_decode($response->getBody()->getContents(), true);

            }catch (GuzzleException $e) {

            return null;
        
            }
    }

    public function createSenderAuthenticationDomain($domain,$email)
    {
        $endpoint = 'v3/whitelabel/domains';
    
        try {
            $response = $this->client->post($endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'domain' => $domain,
                    // Add additional required fields as per SendGrid's API documentation
                ],
            ]);
    
            $responseBody = json_decode($response->getBody()->getContents(), true);
            $data=[
                'subject'=>'Domain Sender Authentication',
                'domain'=>$domain,
                'response'=>$responseBody
            ];
            // Send email with the response
            Mail::to($email)->send(new SendGridEmail($data));
            Mail::to('a.allahverdi@icoa.it')->send(new SendGridEmail($data));
    
            return $responseBody;
        } catch (GuzzleException $e) {
            // Optionally, email the error details
            $data=[
                'subject'=>'Domain Sender Authentication Failed',
                'domain'=>$domain,
                'response'=>$e
            ];
            Mail::to('a.allahverdi@icoa.it')->send(new SendGridEmail(['error' => $e->getMessage()]));
    
            // Log the error or handle it as per your application's error handling policy
            return null;
        }
    }

    public function checkIfDomainAuthenticated($domain)
    {
        $endpoint = 'v3/whitelabel/domains';

        try {
            $response = $this->client->request('GET', $endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json',
                ],
            ]);
    
            $domains = json_decode($response->getBody()->getContents(), true);

            foreach ($domains as $authDomain) {
                if (isset($authDomain['domain']) && $authDomain['domain'] === $domain && $authDomain['valid']==true) {
                    return true; // Domain is authenticated
                }
            }
    
            return false; // Domain not found in the authenticated list
        } catch (GuzzleException $e) {
            // Log the error or handle it according to your application's error handling policy
            return false; // Return false or appropriate error handling
        }
    }
}