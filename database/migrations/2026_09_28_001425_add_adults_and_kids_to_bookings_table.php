<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('number_of_adults')
                ->default(1)
                ->after('number_of_guests');

            $table->unsignedInteger('number_of_kids')
                ->default(0)
                ->after('number_of_adults');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'number_of_adults',
                'number_of_kids',
            ]);
        });
    }
};