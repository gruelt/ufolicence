<?php

namespace App\Console\Commands;

use App\Services\ExAltoService;
use Illuminate\Console\Command;

class ExaltoTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exalto:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test exalto login';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Exalto login test...');

        // Here you would typically call the ExAltoService to perform the login
        // For demonstration, we'll just simulate a successful login

        $exalto = new ExAltoService();

        $token = $exalto->login();

        $this->info( "Exalto Token: " . $token );

        $licencies = $exalto->getLicencies();

         ;



        return Command::SUCCESS;
    }
}
