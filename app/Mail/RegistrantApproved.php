<?php

namespace App\Mail;

use App\Models\Registrant;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrantApproved extends Mailable
{
    use Queueable, SerializesModels;

    public string $rpcQrCode;

    public function __construct(public Registrant $participant)
    {
        if (blank($participant->race_number)) {
            throw new \InvalidArgumentException('Nomor BIB harus tersedia untuk membuat QR pengambilan RPC.');
        }

        $this->rpcQrCode = (new PngWriter())
            ->write(new QrCode(data: 'MUSI-RUN-RPC|'.$participant->race_number, size: 300, margin: 10))
            ->getString();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'MUSI RUN 2027 | Konfirmasi status pendaftaran',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registrant-approved',
        );
    }
}
