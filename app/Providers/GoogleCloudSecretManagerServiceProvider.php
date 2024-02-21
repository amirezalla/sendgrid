<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;

class GoogleCloudSecretManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (app()->environment('production')) {
            $client = new SecretManagerServiceClient();
            $projectName = SecretManagerServiceClient::projectName('icoa-gae');

            $secrets = [
                'APP_NAME',
                'APP_KEY',
                'APP_ENV',
                'LOG_CHANNEL',
                'LOG_DEPRECATIONS_CHANNEL',
                'LOG_LEVEL',
                'BROADCAST_DRIVER',
                'CACHE_DRIVER',
                'CACHE_DRIVER',
                'FILESYSTEM_DISK',
                'QUEUE_CONNECTION',
                'SESSION_DRIVER',
                'SESSION_LIFETIME',
                'MEMCACHED_HOST',
                'REDIS_HOST',
                'REDIS_PASSWORD',
                'REDIS_PORT',
                'MAIL_MAILER',
                'MAIL_HOST',
                'MAIL_PORT',
                'MAIL_USERNAME',
                'MAIL_PASSWORD',
                'MAIL_ENCRYPTION',
                'MAIL_FROM_NAME',
                'MAIL_FROM_ADDRESS',
                // Add other secrets here
            ];

            foreach ($secrets as $secret) {
                $secretName = $client->secretVersionName($projectName, $secret, 'latest');
                $response = $client->accessSecretVersion($secretName);
                $payload = $response->getPayload()->getData();
                putenv("$secret=$payload");
            }
        }
    }

    public function register()
    {
        
    }
}
