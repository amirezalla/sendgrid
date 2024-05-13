<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartNodeServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'node:smtpserver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the Node.js SMTP Server';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting Node.js SMTP Server...');
        $command = 'node '.base_path('node/smtpServer.js');
        while (@ ob_end_flush()); // end all output buffers if any

        $proc = popen($command, 'r');
        while (!feof($proc))
        {
            echo fread($proc, 4096);
            @ flush();
        }
        pclose($proc);

        return 0;
    }
}
