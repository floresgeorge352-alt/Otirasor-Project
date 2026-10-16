<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('extra_shift_requests', function (Blueprint $table) {
            $table->string('request_type')
                ->default('admin')
                ->after('requested_by');
        });

        // Existing requests submitted by employees have the same
        // employee_id and requested_by values.
        DB::table('extra_shift_requests')
            ->whereColumn('employee_id', 'requested_by')
            ->update(['request_type' => 'employee']);
    }

    public function down(): void
    {
        Schema::table('extra_shift_requests', function (Blueprint $table) {
            $table->dropColumn('request_type');
        });
    }
};