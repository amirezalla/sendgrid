<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Smtp;
use App\Models\SmtpHistory;
use Carbon\Carbon;

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
        $currentMonthYear = Carbon::now()->format('m-Y');

        Smtp::all()->each(function ($smtp) use ($currentMonthYear) {
            // Store history
            SmtpUsageHistory::create([
                'smtp_id' => $smtp->id,
                'usage_before_reset' => $smtp->usage,
                'reset_month_year' => $currentMonthYear,
            ]);
            Smtp::query()->update(['usage' => 0]);
        });

        $this->info('Monthly quotas have been reset successfully.');
    }
}
