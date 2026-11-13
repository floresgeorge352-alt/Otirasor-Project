<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class RefundProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Refund Processed - Otirasor Beach and Resort (Booking #' . $this->booking->id . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.refund-processed',
        );
    }

    /**
     * I-attach ang refund proof kung meron man.
     */
    public function attachments(): array
    {
        if (!$this->booking->refund_proof) {
            return [];
        }

        $filePath = $this->booking->refund_proof;
        
        if (!Storage::disk('public')->exists($filePath)) {
            return [];
        }

        $fullPath = Storage::disk('public')->path($filePath);

        return [
            Attachment::fromPath($fullPath)
                ->as('RefundProof_' . $this->booking->id . '.' . pathinfo($filePath, PATHINFO_EXTENSION))
        ];
    }
}