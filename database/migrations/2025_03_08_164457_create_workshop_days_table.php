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
        Schema::create('workshop_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workshop_provider_id')->nullable();
            $table->foreign('workshop_provider_id')->references('id')->on('workshop_providers')->onDelete('cascade');

            $table->string('day')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_days');
    }
};
