<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('gcash_proof')->nullable()->after('gcash_reference');
            $table->string('payment_status')->default('Unverified')->after('gcash_proof');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'gcash_proof',
                'payment_status',
            ]);
        });
    }
};