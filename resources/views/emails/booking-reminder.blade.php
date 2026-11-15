<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: #0077b6; color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; color: #1f2937; line-height: 1.6; }
        .details { background: #f8fcfd; border-left: 4px solid #0077b6; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .details p { margin: 5px 0; }
        .footer { background: #f5f7fa; padding: 20px; text-align: center; font-size: 12px; color: #6b7280; }
        .btn { display: inline-block; background: #0077b6; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; margin-top: 15px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .badge-dayuse { background: #fef3c7; color: #92400e; }
        .badge-overnight { background: #dbeafe; color: #1e40af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏖️ See You Tomorrow!</h1>
        </div>
        <div class="content">
            <p>Hi <strong>{{ $booking->guest_name }}</strong>,</p>
            <p>This is a friendly reminder that your check-in at <strong>Otirasor Beach and Resort</strong> is scheduled for tomorrow!</p>
            
            <div class="details">
                <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                
                @php
                    $isDayUse = \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') === \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d');
                @endphp
                
                <p>
                    <strong>Type:</strong> 
                    @if($isDayUse)
                        <span class="badge badge-dayuse">Day Use</span>
                    @else
                        <span class="badge badge-overnight">Overnight</span>
                    @endif
                </p>

                <p><strong>Check-in Date:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</p>
                
                @if(!$isDayUse)
                    <p><strong>Check-out Date:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</p>
                @endif
                
                <p><strong>Number of Guests:</strong> {{ $booking->number_of_guests }}</p>
            </div>

            <p><strong>Reminders before you arrive:</strong></p>
            <ul>
                <li>Please bring a valid ID for verification.</li>
                @if($isDayUse)
                    <li>Day Use check-in time starts at 8:00 AM.</li>
                @else
                    <li>Overnight check-in time starts at 2:00 PM.</li>
                @endif
                <li>Don't forget your swimming gear!</li>
            </ul>

            <p>If you have any questions, feel free to contact us.</p>
            <p>We look forward to seeing you!</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 Otirasor Beach and Resort. All Rights Reserved.</p>
            <p>Brgy. Talaban, Negros Occidental, Philippines</p>
        </div>
    </div>
</body>
</html>