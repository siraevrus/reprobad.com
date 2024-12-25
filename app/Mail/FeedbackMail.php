<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public function __construct(array $message)
    {
        $this->message = $message;
    }

    public function build()
    {
        return $this->markdown('mail.feedback')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->to(env('MAIL_TO_ADDRESS'))
            ->subject('Обратная связь на сайте Repro')
            ->with([
                'name' => $this->message['name'],
                'email' => $this->message['email'],
                'phone' => $this->message['phone'],
                'message' => $this->message['message'],
            ]);
    }
}
