<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;

class CancellationService
{
    /**
     * Compute the refund details based on check-in date.
     *
     * @return array ['percentage' => int, 'amount' => float, 'policy' => string]
     */
    public function computeRefund(Booking $booking): array
    {
        $checkIn = Carbon::parse($booking->check_in)->startOfDay();
        $now = Carbon::now()->startOfDay();
        $daysBefore = $now->diffInDays($checkIn, false);

        // Kung tapos na ang check-in date (negative days), walang refund
        if ($daysBefore < 0) {
            return $this->buildResult($booking, 0, 'Booking has already started or past check-in.');
        }

        // Policy Rules
        if ($daysBefore >= 7) {
            return $this->buildResult($booking, 100, 'Cancelled 7+ days before check-in. Full refund.');
        }

        if ($daysBefore >= 3) {
            return $this->buildResult($booking, 50, 'Cancelled 3-6 days before check-in. 50% refund.');
        }

        return $this->buildResult($booking, 0, 'Cancelled less than 3 days before check-in. No refund.');
    }

    private function buildResult(Booking $booking, int $percentage, string $policy): array
    {
        $totalPaid = $booking->net_total;
        $amount = round($totalPaid * ($percentage / 100), 2);

        return [
            'percentage' => $percentage,
            'amount' => $amount,
            'policy' => $policy,
        ];
    }
}