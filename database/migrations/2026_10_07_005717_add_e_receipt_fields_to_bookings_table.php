<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('receipt_number')
                ->nullable()
                ->unique()
                ->after('cancellation_status');

            $table->timestamp('receipt_generated_at')
                ->nullable()
                ->after('receipt_number');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'receipt_number',
                'receipt_generated_at',
            ]);
        });
    }
};