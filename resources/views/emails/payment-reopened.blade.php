<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Re-opened</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f8fc; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="color: #023e8a; margin-top: 0;">Payment Re-opened</h2>
        <p>Hello <strong>{{ $booking->guest_name }}</strong>,</p>
        <p>Your payment proof for <strong>Booking #{{ $booking->id }}</strong> has been re-opened by the admin.</p>
        <p>Please log in to your account and re-upload a valid GCash payment proof so we can process your booking.</p>
        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ url('/my-bookings') }}" style="background: #0077b6; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold;">Re-upload Payment Proof</a>
        </div>
        <p style="color: #6c7a86; font-size: 13px;">If you have any questions, please contact us.</p>
        <p style="color: #6c7a86; font-size: 13px;">Thank you,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>