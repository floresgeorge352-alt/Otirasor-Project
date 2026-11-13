<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accommodations', function (Blueprint $table) {
            $table->date('maintenance_start')->nullable()->after('status');
            $table->date('maintenance_end')->nullable()->after('maintenance_start');
            $table->string('maintenance_reason')->nullable()->after('maintenance_end');
        });
    }

    public function down(): void
    {
        Schema::table('accommodations', function (Blueprint $table) {
            $table->dropColumn(['maintenance_start', 'maintenance_end', 'maintenance_reason']);
        });
    }
};