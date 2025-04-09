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
        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('part_type')->nullable();
            $table->unsignedBigInteger(column: 'brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('car_brands')->onDelete('cascade');
            
            $table->text('desc')->nullable();
            $table->string('engine')->nullable();
            $table->string('vin_number')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};
