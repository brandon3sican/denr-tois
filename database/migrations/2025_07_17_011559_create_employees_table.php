<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->integer('age');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('address');
            $table->string('contact_num');
            $table->date('birthdate');
            $table->date('date_hired');
            
            // Foreign Keys
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->foreignId('div_sec_unit_id')->constrained('div_sec_units')->onDelete('cascade');
            $table->foreignId('employment_status_id')->constrained('employment_statuses')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
