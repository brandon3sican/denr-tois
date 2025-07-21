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
        // Travel Order Statuses Table
        Schema::create('travel_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Travel Order User Types Table (for signatories)
        Schema::create('travel_order_user_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'Recommender', 'Approver', 'Requester'
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Travel Orders Table
        Schema::create('travel_orders', function (Blueprint $table) {
            $table->id();
            
            // Header
            $table->string('region');
            $table->text('address');
            $table->date('date');
            
            // Travel Order Details
            $table->string('travel_order_no')->unique();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            // Employee details (denormalized for record-keeping)
            $table->string('full_name');
            $table->decimal('salary', 12, 2);
            $table->string('position');
            $table->string('div_sec_unit');
            $table->date('departure_date');
            $table->string('official_station');
            $table->string('destination');
            $table->date('arrival_date');
            $table->text('purpose_of_travel');
            
            // Allowances and Approvals
            $table->decimal('per_diem_expenses', 12, 2)->default(0);
            $table->integer('assistant_or_laborers_allowed')->default(0);
            $table->string('appropriations')->nullable();
            $table->text('remarks')->nullable();
            
            // Status
            $table->foreignId('status_id')->constrained('travel_order_statuses');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });

        // Travel Order Signatories
        Schema::create('travel_order_signatories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_order_id')->constrained('travel_orders')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('user_type_id')->constrained('travel_order_user_types');
            $table->boolean('is_signed')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->text('signature_path')->nullable();
            $table->timestamps();
            
            $table->unique(['travel_order_id', 'user_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_order_signatories');
        Schema::dropIfExists('travel_orders');
        Schema::dropIfExists('travel_order_user_types');
        Schema::dropIfExists('travel_order_statuses');
    }
};
