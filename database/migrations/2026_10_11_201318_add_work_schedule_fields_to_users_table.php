<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->time('regular_time_in')->nullable();
            $table->time('regular_time_out')->nullable();
            $table->unsignedSmallInteger('unpaid_break_minutes')->default(60);
            $table->unsignedSmallInteger('grace_period_minutes')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'regular_time_in',
                'regular_time_out',
                'unpaid_break_minutes',
                'grace_period_minutes',
            ]);
        });
    }
};