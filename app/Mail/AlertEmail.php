<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $smtp;

    public function __construct($smtp)
    {
        $this->smtp = $smtp;
    }

    public function build()
    {
        $email = $this->view('emails.alert')
                      ->subject($this->smtp['domain'].' Has reached its alert limit.') // Set the email subject
                      ->with([
                        'smtp'=>$this->smtp
                        ]); // Pass the message to the view
        
        return $email;
    }
}
