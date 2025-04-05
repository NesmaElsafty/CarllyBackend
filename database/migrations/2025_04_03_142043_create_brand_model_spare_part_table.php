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
        Schema::create('brand_model_spare_part', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('brand_model_id')->nullable();
            $table->foreign('brand_model_id')->references('id')->on('brand_models')->onDelete('cascade');

            $table->unsignedBigInteger('spare_part_id')->nullable();
            $table->foreign('spare_part_id')->references('id')->on('spare_parts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_model_spare_part');
    }
};
