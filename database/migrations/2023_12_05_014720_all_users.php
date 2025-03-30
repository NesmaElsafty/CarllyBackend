<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('allusers', function (Blueprint $table) {
            $table->id();
            $table->string('usertype')->nullable()->default('fromuserapp'); 
            $table->string('image')->nullable()->default('icons/profile.png'); 
            $table->string('fname')->nullable()->default('name1');
            $table->string('lname')->nullable()->default('name2');
            $table->string('phone')->nullable()->default('0301234567'); 
            $table->string('email')->nullable()->default('email@gmail.com');
            $table->string('password')->nullable()->default('1234');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};