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
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('First_Name');
            $table->string('Last_Name');
            $table->string('Surname');
            $table->string('Gender');
            $table->integer('Phone_number');
            $table->string('Email_Adress');
            $table->string('Guardian_Name');
            $table->string('Guardian_Phonenumber');
            $table->string('Course');
            $table->string('Reg_Date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};
