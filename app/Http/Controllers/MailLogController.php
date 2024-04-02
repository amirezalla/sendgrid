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
        $csv = Writer::createFromFileObject(new \SplTempFileObject()); // create a temporary file
        $csv->insertOne(['Recipient', 'Subject', 'Sender', 'HTML Content', 'Sent At', 'Via']); // Header

        $mailLogs = Maillog::all(); // Retrieve all Maillog records
        foreach ($mailLogs as $mailLog) {
            $csv->insertOne($mailLog->toArray()); // Insert each record into the CSV
        }

        $csv->output('maillog_export_' . date('Y-m-d_His') . '.csv'); // Output the CSV to the browser
        return response()->streamDownload(function () use ($csv) {
            echo $csv->getContent();
        }, 'maillog_export_' . date('Y-m-d_His') . '.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="maillog_export_' . date('Y-m-d_His') . '.csv"',
        ]);
    }
}