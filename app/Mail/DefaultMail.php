<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DefaultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public function __construct(array $message)
    {
        $this->message = $message;
    }

    public function build()
    {
        return $this->markdown('mail.default')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Новая заявка на сайте Repro')
            ->with([
                'email' => $this->message['email'],
            ]);
    }
}
