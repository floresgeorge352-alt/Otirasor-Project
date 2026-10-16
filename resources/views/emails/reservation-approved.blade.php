<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>
        Reservation Approved
    </title>
</head>

<body>

    <h2>
        Reservation Approved!
    </h2>


    <p>
        Hello {{ $booking->guest_name }},
    </p>


    <p>
        We are happy to inform you that your reservation
        at <strong>Otirasor Beach and Resort</strong>
        has been approved.
    </p>


    <hr>


    <h3>
        Electronic Receipt
    </h3>


    <p>
        <strong>Receipt Number:</strong>
        {{ $booking->receipt_number }}
    </p>


    <p>
        <strong>Receipt Generated:</strong>
        {{ $booking->receipt_generated_at }}
    </p>


    <hr>


    <h3>
        Reservation Details
    </h3>


    <p>

        <strong>Booking Number:</strong>
        #{{ $booking->id }}

        <br>

        <strong>Guest Name:</strong>
        {{ $booking->guest_name }}

        <br>

        <strong>Contact Number:</strong>
        {{ $booking->contact_number }}

        <br>

        <strong>Number of Adults:</strong>
        {{ $booking->number_of_adults }}

        <br>

        <strong>Number of Kids:</strong>
        {{ $booking->number_of_kids }}

        <br>

        <strong>Total Guests:</strong>
        {{ $booking->number_of_guests }}

        <br>

        <strong>Accommodation:</strong>
        {{ $booking->accommodations }}

        <br>

        <strong>Check-in:</strong>
        {{ $booking->check_in }}

        <br>

        <strong>Check-out:</strong>
        {{ $booking->check_out }}

        <br>

        <strong>Payment Method:</strong>
        {{ $booking->payment_method }}

    </p>


    @if($booking->payment_method === 'GCash')

        <p>

            <strong>GCash Reference:</strong>
            {{ $booking->gcash_reference }}

            <br>

            <strong>Payment Status:</strong>
            {{ $booking->payment_status }}

        </p>

    @endif


    <hr>


    <!-- ==========================================
         PAYMENT BREAKDOWN
    =========================================== -->

    <h3>
        Payment Breakdown
    </h3>


    <p>

        <strong>Accommodation Total:</strong>
        ₱{{ number_format(
            (float) $booking->accommodation_total,
            2
        ) }}

    </p>


    @php

        $entranceAdults =
            (int) ($booking->number_of_adults ?? 0);

        $entranceKids =
            (int) ($booking->number_of_kids ?? 0);

        $poolAdults =
            (int) ($booking->pool_adults ?? 0);

        $poolKids =
            (int) ($booking->pool_kids ?? 0);

        $entranceTotal =
            ($entranceAdults * 20) +
            ($entranceKids * 10);

        $poolTotal =
            ($poolAdults * 70) +
            ($poolKids * 50);

        $facilityTotal =
            (float) $booking->facility_total;

        $grandTotal =
            (float) $booking->accommodation_total +
            $facilityTotal;

    @endphp


    <h4>
        Beach Entrance
    </h4>


    <p>

        <strong>Adults:</strong>
        {{ $entranceAdults }}
        × ₱20 =
        ₱{{ number_format(
            $entranceAdults * 20,
            2
        ) }}

        <br>

        <strong>Kids:</strong>
        {{ $entranceKids }}
        × ₱10 =
        ₱{{ number_format(
            $entranceKids * 10,
            2
        ) }}

        <br>

        <strong>Entrance Total:</strong>
        ₱{{ number_format(
            $entranceTotal,
            2
        ) }}

    </p>


    <h4>
        Swimming Pool
    </h4>


    <p>

        <strong>Adults:</strong>
        {{ $poolAdults }}
        × ₱70 =
        ₱{{ number_format(
            $poolAdults * 70,
            2
        ) }}

        <br>

        <strong>Kids:</strong>
        {{ $poolKids }}
        × ₱50 =
        ₱{{ number_format(
            $poolKids * 50,
            2
        ) }}

        <br>

        <strong>Pool Total:</strong>
        ₱{{ number_format(
            $poolTotal,
            2
        ) }}

    </p>


    <p>

        <strong>Facility Total:</strong>
        ₱{{ number_format(
            $facilityTotal,
            2
        ) }}

        <br><br>

        <strong>GRAND TOTAL:</strong>
        ₱{{ number_format(
            $grandTotal,
            2
        ) }}

    </p>


    <hr>


    <p>

        <strong>Booking Status:</strong>
        {{ $booking->status }}

    </p>


    <hr>


    <p>
        Your electronic receipt has been generated
        and is now available in your account.
    </p>


    <p>
        You can also view your electronic receipt
        from the <strong>My Bookings</strong> page
        of the Otirasor Beach and Resort website.
    </p>


    <hr>


    <p>
        Thank you for choosing
        <strong>Otirasor Beach and Resort</strong>.
    </p>


    <p>
        We look forward to welcoming you!
    </p>

</body>
</html>