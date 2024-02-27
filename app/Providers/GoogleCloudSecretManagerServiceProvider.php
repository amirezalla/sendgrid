<?php

namespace App\Providers;

use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;


class GoogleCloudSecretManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
// Only run this in production
            try {
                // Instantiates a client
                $client = new SecretManagerServiceClient();

                // Build the resource name of the secret version
                $secretName = $client->secretVersionName('341264949013', 'sendgrid-env', 'latest');

                // Access the secret version
                $response = $client->accessSecretVersion($secretName);
                $payload = $response->getPayload()->getData();

                if (strpos($payload, '=') !== false) {
                    // Parse the payload as a .env string
                    $lines = explode("\n", $payload);
                    foreach ($lines as $line) {
                        if (!empty($line) && strpos($line, '=') !== false) {
                            list($key, $value) = explode('=', $line, 2);
                            $key = trim($key);
                            $value = trim($value);
                            putenv("$key=$value");
                            Config::set('mail.mailers.smtp.password', $value);
                            $_ENV[$key] = $value;
                            $_SERVER[$key] = $value;
                        }
                    }
                }
                
            } catch (\Exception $e) {
                // Handle exceptions, potentially log them or alert in some way
                error_log('Error fetching secrets from Google Secret Manager: ' . $e->getMessage());
            }

    }

    public function register()
    {
        //
    }
}