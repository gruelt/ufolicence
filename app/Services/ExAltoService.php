<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ExAltoService
{
    /**
     * Create a new class instance.
     */
    private $username;
    private $password;

    private $token;


    private $apiUrl;

    private $debug = true;

    public function __construct()
    {
        $this->username = config('services.exalto.username');
        $this->password = config('services.exalto.password');
        $this->apiUrl = config('services.exalto.api_url'    );
        $this->debug = true;
    }


    /**
     * Login to Exalto API and retrieve token
     * If cached token exists, use it , otherwise perform login with credentials
     */
    public function login()
    {
        $token = Cache::get('exalto_token');

        if ($token !== null) {
            //print 'TOken found ';
            $this->token = $token;
            return $token;
        }

        $endpoint = $this->apiUrl . '/login';

        //http login to exalto
        $login = Http::post($endpoint,
            [
                'username' => $this->username,
                'password' => $this->password,
            ]);

        if ($login->successful()) {
            $responseBody = $login->json();
            $token = $responseBody['success']['token'];
            Cache::put('exalto_token', $token, now()->addMinutes(55));
            print 'New token stored in cache ';
        } else {
            print 'Login failed with status: ' . $login->status();
        }

        $this->token = $token;

        return $token;

    }


    public function getLicencies($par_page = 5000, $page = 1)
    {
        $this->login();

        $endpoint = $this->apiUrl . '/licencies';

        print_r("Fetching Licencies Resource from Exalto at endpoint: " . $endpoint . "\n");

        $response = Http::withToken($this->token)
            ->get($endpoint,
                [
                    'par_page' => 5000,
                    'page' => 1,
                ]
            );


        if ($response->successful()) {
            $responseBody = $response->json('data');
            print_r($responseBody);
        } else {
            print 'Failed to fetch licencies resource with status: ' . $response->status();
            return null;
        }
    }



}
