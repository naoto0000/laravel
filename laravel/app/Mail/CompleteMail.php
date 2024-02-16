<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_name)
    {
        $this->mail_name = $mail_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.complete');
    }
}
