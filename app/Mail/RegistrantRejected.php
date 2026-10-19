<?php

namespace App\Mail;

use App\Models\Registrant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrantRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Registrant $participant)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'MUSI RUN 2027 | Informasi status pendaftaran',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registrant-rejected',
        );
    }
}
