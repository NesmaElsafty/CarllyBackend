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
        Schema::create('sparepart_year', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'sparepart_id')->nullable();
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('cascade');

            $table->unsignedBigInteger(column: 'year_id')->nullable();
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sparepart_year');
    }
};
