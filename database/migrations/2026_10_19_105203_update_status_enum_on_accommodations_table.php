<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the ENUM to include 'maintenance'
        DB::statement("ALTER TABLE accommodations MODIFY COLUMN status ENUM('available', 'unavailable', 'maintenance') NOT NULL DEFAULT 'available'");
    }

    public function down(): void
    {
        // Revert back to original ENUM
        DB::statement("ALTER TABLE accommodations MODIFY COLUMN status ENUM('available', 'unavailable') NOT NULL DEFAULT 'available'");
    }
};