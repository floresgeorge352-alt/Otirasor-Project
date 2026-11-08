<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_accommodation', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->cascadeOnDelete();

            $table->foreignId('accommodation_id')
                ->constrained('accommodations')
                ->cascadeOnDelete();

            // Store price at time of booking (for history)
            $table->decimal('price_at_booking', 10, 2)->default(0);

            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['booking_id', 'accommodation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_accommodation');
    }
};