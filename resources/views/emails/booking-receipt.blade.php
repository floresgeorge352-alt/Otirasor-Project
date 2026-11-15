<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2 style="color: #0077b6;">Your Booking is Verified!</h2>
    <p>Hi {{ $booking->guest_name }},</p>
    <p>Good news! Your payment for <strong>Booking #{{ $booking->id }}</strong> has been verified.</p>
    <p>Attached to this email is your Acknowledgement Receipt.</p>
    <br>
    <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</p>
    <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</p>
    <p><strong>Total Amount:</strong> ₱{{ number_format($booking->net_total, 2) }}</p>
    <br>
    <p>Thank you for booking with us!</p>
    <p>— Otirasor Beach and Resort</p>
</body>
</html>