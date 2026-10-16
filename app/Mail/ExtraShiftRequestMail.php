<?php

namespace App\Mail;

use App\Models\ExtraShiftRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExtraShiftRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ExtraShiftRequest $shiftRequest
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Extra Shift Request - Otirasor Beach and Resort',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.extra-shift-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}