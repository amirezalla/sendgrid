<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $email = $this->view('emails.engine') // Use the specified view
                      ->from($this->data['address'], $this->data['name']??$this->data['address']) // Set the "from" address
                      ->subject($this->data['subject']) // Set the email subject
                      ->with(['emailMessage' => $this->data['message']]); // Pass the message to the view

        // Check and set "to" address, using the provided name or defaulting to address
        $email->to($this->data['to'], $this->data['to_name'] ?? $this->data['to']);

        // Check and set "cc" if provided
        if (isset($this->data['cc_address'])) {
            $email->cc($this->data['cc_address'], $this->data['cc_name'] ?? null);
        }

        // Check and set "bcc" if provided
        if (isset($this->data['bcc_address'])) {
            $email->bcc($this->data['bcc_address'], $this->data['bcc_name'] ?? null);
        }

        return $email;
    }
}
