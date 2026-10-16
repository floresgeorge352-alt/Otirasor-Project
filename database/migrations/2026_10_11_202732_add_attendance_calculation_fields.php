
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedInteger('late_minutes')->default(0);
            $table->unsignedInteger('undertime_minutes')->default(0);
            $table->unsignedInteger('overtime_minutes')->default(0);

            $table->string('overtime_status')
                ->default('Not Requested');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'late_minutes',
                'undertime_minutes',
                'overtime_minutes',
                'overtime_status',
            ]);
        });
    }
};
