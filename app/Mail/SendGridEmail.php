<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendGridEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $email = $this->view('emails.SGResponse')
                      ->subject($this->data['subject']) // Set the email subject
                      ->with([
                        'response' => $this->data['response'],
                        'domain'=>$this->data['domain']
                        ]); // Pass the message to the view
        
        return $email;
    }
}