<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Smtp;

class ResetMonthlyQuotas extends Command
{
    protected $signature = 'quotas:reset';
    protected $description = 'Reset monthly quotas for all SMTP records';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        Smtp::query()->update(['usage' => 0]);

        $this->info('Monthly quotas have been reset successfully.');
    }
}
