<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reservation Rejected</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <h2>Reservation Rejected</h2>

    <p>
        Hello {{ $booking->user->name }},
    </p>

    <p>
        We are sorry to inform you that your reservation
        <strong>#{{ $booking->id }}</strong>
        at <strong>Otirasor Beach and Resort</strong>
        has been rejected.
    </p>

    <p>
        <strong>Reason for Rejection:</strong>
    </p>

    <div style="
        background: #fff5f5;
        border-left: 4px solid #c62828;
        padding: 12px 15px;
        margin: 15px 0;
    ">
        {{ $booking->rejection_reason }}
    </div>

    <p>
        <strong>Reservation Details:</strong>
    </p>

    <ul>
        <li>
            <strong>Guests:</strong>
            {{ $booking->number_of_guests }}
        </li>

        <li>
            <strong>Check-in:</strong>
            {{ $booking->check_in }}
        </li>

        <li>
            <strong>Check-out:</strong>
            {{ $booking->check_out }}
        </li>

        <li>
            <strong>Payment Method:</strong>
            {{ $booking->payment_method }}
        </li>
    </ul>

    <p>
        If you have any questions, please contact
        <strong>Otirasor Beach and Resort</strong>.
    </p>

    <p>
        Thank you for choosing Otirasor Beach and Resort.
    </p>

</body>
</html>