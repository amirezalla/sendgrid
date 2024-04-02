<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maillog;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\Response;

class MailLogController extends Controller
{
    public function exportCsv(Request $request)
    {
        $fileName = 'maillog_export_' . date('Y-m-d_His') . '.csv';
        $mailLogs = Maillog::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['Recipient', 'Subject', 'Sender', 'HTML Content', 'Sent At', 'Via'];

        $callback = function() use($mailLogs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($mailLogs as $mailLog) {
                $row = [
                    $mailLog->recipient,
                    $mailLog->subject,
                    $mailLog->sender,
                    $mailLog->html, // Ensure this does not contain commas or escape properly
                    $mailLog->sent_at,
                    $mailLog->via,
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}