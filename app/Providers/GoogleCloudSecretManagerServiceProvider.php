<?php

namespace App\Providers;

use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;
use Illuminate\Support\ServiceProvider;

class GoogleSecretsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (app()->environment('production')) { // Only run this in production
            try {
                // Instantiates a client
                $client = new SecretManagerServiceClient();

                // Build the resource name of the secret version
                $secretName = $client->secretVersionName('341264949013', 'sendgrid-env', 'latest');

                // Access the secret version
                $response = $client->accessSecretVersion($secretName);
                $payload = $response->getPayload()->getData();

                // Assuming the secret payload is a JSON string with your env variables
                $envVars = json_decode($payload, true);
                if (is_array($envVars)) {
                    foreach ($envVars as $key => $value) {
                        // Set the environment variable
                        putenv("$key=$value");
                    }
                }
            } catch (\Exception $e) {
                // Handle exceptions, potentially log them or alert in some way
                error_log('Error fetching secrets from Google Secret Manager: ' . $e->getMessage());
            }
        }
    }

    public function register()
    {
        //
    }
}