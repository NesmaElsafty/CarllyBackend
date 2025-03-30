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
        Schema::create('workshop_category_provider', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workshop_category_id');
            $table->foreign('workshop_category_id')->references('id')->on('workshop_categories')->onDelete('cascade');
            $table->unsignedBigInteger('workshop_provider_id');
            $table->foreign('workshop_provider_id')->references('id')->on('workshop_providers')->onDelete('cascade');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_category_provider');
    }
};
