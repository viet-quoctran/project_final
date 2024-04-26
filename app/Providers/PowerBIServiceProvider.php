<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class PowerBIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->app->singleton('PowerBIClient', function ($app) {
            $client = new Client();
            $response = $client->post('https://login.microsoftonline.com/' . env('TENANT_ID') . '/oauth2/token', [
                'form_params' => [
                    'client_id' => env('APPLICATION_ID'),
                    'scope' => 'https://graph.microsoft.com/.default',
                    'client_secret' => env('APPLICATION_SECRET'),
                    'grant_type' => 'client_credentials',
                    'resource' => 'https://analysis.windows.net/powerbi/api',
                ],
            ]);

            $body = json_decode((string) $response->getBody());
            $access_token = $body->access_token;
            // Sau khi có Access Token, lấy Embed Token
            $response = $client->post('https://api.powerbi.com/v1.0/myorg/reports/' . env('REPORT_ID') . '/GenerateToken', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                ],
                'json' => [
                    'accessLevel' => 'View',
                ],
            ]);

            $body = json_decode((string) $response->getBody());
            $embed_token = $body->token;

            return $embed_token;
        });
    }
}
