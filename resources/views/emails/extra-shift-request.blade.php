<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Extra Shift Request</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">

    <h2>Extra Shift Request</h2>

    <p>Hello {{ $shiftRequest->employee->name ?? 'Employee' }},</p>

    <p>
        Otirasor Beach and Resort is asking if you are available
        to work an extra shift on your scheduled rest day.
    </p>

    <h3>Shift Details</h3>

    <p>
        <strong>Date:</strong>
        {{ $shiftRequest->shift_date->format('F d, Y') }}
    </p>

    <p>
        <strong>Start Time:</strong>
        {{ \Carbon\Carbon::parse($shiftRequest->start_time)->format('h:i A') }}
    </p>

    <p>
        <strong>End Time:</strong>
        {{ \Carbon\Carbon::parse($shiftRequest->end_time)->format('h:i A') }}
    </p>

    <p>
        <strong>Reason:</strong>
        {{ $shiftRequest->reason ?: 'Additional staff needed.' }}
    </p>

    <p>
        Please log in to your employee account to respond
        <strong>Available</strong> or <strong>Unavailable</strong>.
    </p>

    <p>
        <a href="{{ route('employee.dashboard') }}"
           style="display: inline-block; padding: 12px 20px;
                  background-color: #166534; color: #fff;
                  text-decoration: none; border-radius: 5px;">
            Open Employee Dashboard
        </a>
    </p>

    <p>
        <strong>Note:</strong> This is a request only. The extra shift
        is not confirmed until the administrator confirms it.
    </p>

    <p>Thank you,<br>
    Otirasor Beach and Resort</p>

</body>
</html>