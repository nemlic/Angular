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
        Schema::create('attendants', function (Blueprint $table) {
            $table->id();
            $table->string('id_number'); 
            $table->string('firstName'); 
            $table->string('surname');    
            $table->string('lastName');   
            $table->string('phone');     
            $table->string('email')->unique(); 
            $table->string('station')->nullable(); 
            $table->string('nextofKin')->nullable(); 
            $table->string('contactofKin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendants');
    }
};
