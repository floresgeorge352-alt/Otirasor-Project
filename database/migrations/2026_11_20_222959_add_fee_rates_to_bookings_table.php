
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('entrance_adult_rate', 10, 2)->nullable();
            $table->decimal('entrance_child_rate', 10, 2)->nullable();
            $table->decimal('swimming_adult_rate', 10, 2)->nullable();
            $table->decimal('swimming_child_rate', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'entrance_adult_rate',
                'entrance_child_rate',
                'swimming_adult_rate',
                'swimming_child_rate',
            ]);
        });
    }
};
