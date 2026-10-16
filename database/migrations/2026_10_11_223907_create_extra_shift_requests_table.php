<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extra_shift_requests', function (Blueprint $table) {
            $table->id();

            // Employee na inaalok ng extra shift
            $table->foreignId('employee_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Admin na gumawa ng request
            $table->foreignId('requested_by')
                ->constrained('users')
                ->cascadeOnDelete();

            // Schedule ng extra shift
            $table->date('shift_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('reason')->nullable();

            // Sagot ng employee
            $table->enum('employee_response', [
                'Pending',
                'Available',
                'Unavailable',
            ])->default('Pending');

            // Desisyon ng admin
            $table->enum('status', [
                'Pending',
                'Confirmed',
                'Rejected',
                'Cancelled',
            ])->default('Pending');

            $table->timestamp('responded_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extra_shift_requests');
    }
};