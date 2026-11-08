<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Idinagdag ang bagong column para sa refund reason
            $table->string('refund_request_reason')->nullable()->after('refund_notes');
            
            // Kung ang refund_status ay existing na column, 
            // palitan natin ang default value nito para maging 'Not Requested'
            // (Kung wala pang refund_status column sa database mo, tanggalin ang ->change() at gawin na lang itong bagong column)
            if (Schema::hasColumn('bookings', 'refund_status')) {
                $table->string('refund_status')->default('Not Requested')->change();
            } else {
                $table->string('refund_status')->default('Not Requested')->after('refund_request_reason');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('refund_request_reason');
            
            // Ibinalik sa dating default (kung mayroon man)
            if (Schema::hasColumn('bookings', 'refund_status')) {
                $table->string('refund_status')->default(null)->change();
            }
        });
    }
};