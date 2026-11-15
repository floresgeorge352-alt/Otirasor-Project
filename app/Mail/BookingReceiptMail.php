<?php

namespace App\Mail;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingReceiptMail extends Mailable
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
            subject: 'Your Acknowledgement Receipt - Otirasor Beach',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-receipt',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('customer.receipt-pdf', ['booking' => $this->booking])
            ->setPaper('A4', 'portrait');

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Receipt-' . ($this->booking->receipt_number ?? $this->booking->id) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}