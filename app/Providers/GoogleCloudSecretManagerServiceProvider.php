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

                $storedValue = getenv('MAIL_PASSWORDENC'); // Replace MY_ENV_VARIABLE with your actual environment variable
                $method = 'AES-256-CBC'; // Must be the same method used for encryption
                // Generate an initialization vector
                $ivLength = openssl_cipher_iv_length($method);
                $iv = openssl_random_pseudo_bytes($ivLength);
                $password = 'Amir208079@'; // Must be the same key used for encryption

                // Decode the stored value to get the IV and encrypted data
                list($iv, $encrypted) = explode('::', base64_decode($storedValue), 2);

                // Decrypt the data
                $decrypted = openssl_decrypt($encrypted, $method, $password, $options=0, $iv);


                putenv("MAIL_PASSWORD=$decrypted");
                Config::set('mail.mailers.smtp.password', $decrypted);
                $_ENV["MAIL_PASSWORD"] = $decrypted;
                $_SERVER["MAIL_PASSWORD"] = $decrypted;


                $storedValue = getenv('GCI_ENC'); // Replace MY_ENV_VARIABLE with your actual environment variable
                $method = 'AES-256-CBC'; // Must be the same method used for encryption
                // Generate an initialization vector
                $ivLength = openssl_cipher_iv_length($method);
                $iv = openssl_random_pseudo_bytes($ivLength);
                $password = 'Amir208079@'; // Must be the same key used for encryption

                // Decode the stored value to get the IV and encrypted data
                list($iv, $encrypted) = explode('::', base64_decode($storedValue), 2);

                // Decrypt the data
                $decrypted = openssl_decrypt($encrypted, $method, $password, $options=0, $iv);
                        putenv("GOOGLE_CLIENT_ID=$decrypted");
                        Config::set('services.google.client_id', $decrypted);
                        $_ENV["GOOGLE_CLIENT_ID"] = $decrypted;
                        $_SERVER["GOOGLE_CLIENT_ID"] = $decrypted;


                        $storedValue = getenv('GCS_ENC'); // Replace MY_ENV_VARIABLE with your actual environment variable
                        $method = 'AES-256-CBC'; // Must be the same method used for encryption
                        // Generate an initialization vector
                        $ivLength = openssl_cipher_iv_length($method);
                        $iv = openssl_random_pseudo_bytes($ivLength);
                        $password = 'Amir208079@'; // Must be the same key used for encryption
        
                        // Decode the stored value to get the IV and encrypted data
                        list($iv, $encrypted) = explode('::', base64_decode($storedValue), 2);
        
                        // Decrypt the data
                        $decrypted = openssl_decrypt($encrypted, $method, $password, $options=0, $iv);
                                putenv("GOOGLE_CLIENT_SECRET=$decrypted");
                                Config::set('services.google.client_secret', $decrypted);
                                $_ENV["GOOGLE_CLIENT_SECRET"] = $decrypted;
                                $_SERVER["GOOGLE_CLIENT_SECRET"] = $decrypted;
                


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
