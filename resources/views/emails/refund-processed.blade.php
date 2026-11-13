<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Refund Processed</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header { background: #023e8a; color: white; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; }
        .content { padding: 30px; line-height: 1.6; }
        .details-box { background: #ecfdf3; border: 1px solid #bbf7d0; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .details-box p { margin: 5px 0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #888; background: #f8fafc; }
        .btn { display: inline-block; padding: 10px 20px; background: #0077b6; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; font-weight: bold; }
        .proof-note { margin-top: 20px; padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; color: #166534; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Otirasor Beach and Resort</h1>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $booking->guest_name }}</strong>,</p>
            
            <p>Good news! Your refund request for <strong>Booking #{{ $booking->id }}</strong> has been processed and sent back to your GCash account.</p>
            
            <div class="details-box">
                <p><strong>Refund Amount:</strong> ₱{{ number_format(($booking->accommodation_total ?? 0) + ($booking->facility_total ?? 0) - ($booking->discount_amount ?? 0) - ($booking->reward_discount ?? 0), 2) }}</p>
                <p><strong>GCash Reference No:</strong> {{ $booking->refund_reference }}</p>
                @if($booking->refund_message)
                    <p><strong>Message from Admin:</strong> "{{ $booking->refund_message }}"</p>
                @endif
            </div>

            @if($booking->refund_proof)
                <div class="proof-note">
                    📷 <strong>Proof of Refund Attached:</strong> A copy of the refund proof is attached to this email. Please keep it for your records.
                </div>
            @endif

            <p>Please check your GCash app to confirm receipt. If you have any questions, feel free to contact us.</p>
            
            <p>Thank you for choosing Otirasor Beach and Resort.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Otirasor Beach and Resort. All Rights Reserved.
        </div>
    </div>
</body>
</html>