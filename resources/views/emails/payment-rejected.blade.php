<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>GCash Payment Rejected</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <h2>GCash Payment Rejected</h2>

    <p>
        Hello {{ $booking->guest_name }},
    </p>

    <p>
        We are sorry to inform you that your GCash payment
        for your Otirasor Beach and Resort booking has been rejected.
    </p>

    <h3>Payment Details</h3>

    <p>
        <strong>GCash Reference:</strong>
        {{ $booking->gcash_reference }}
    </p>

    <p>
        <strong>Payment Status:</strong>
        Rejected
    </p>

    <h3>Reason for Rejection</h3>

    <p style="background: #f8f8f8; padding: 15px; border-left: 4px solid #dc3545;">
        {{ $booking->payment_rejection_reason }}
    </p>

    <p>
        Please review the payment information and submit a valid
        GCash payment proof if you still want to continue with your booking.
    </p>

    <p>
        Thank you,<br>
        <strong>Otirasor Beach and Resort</strong>
    </p>

</body>
</html>