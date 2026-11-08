<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'reward_points_used')) {
                $table->integer('reward_points_used')->default(0)->after('discount_amount');
            }
            if (!Schema::hasColumn('bookings', 'reward_discount')) {
                $table->decimal('reward_discount', 10, 2)->default(0)->after('reward_points_used');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'reward_points_used')) {
                $table->dropColumn('reward_points_used');
            }
            if (Schema::hasColumn('bookings', 'reward_discount')) {
                $table->dropColumn('reward_discount');
            }
        });
    }
};