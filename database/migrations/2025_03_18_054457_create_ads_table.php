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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->longText('caption')->nullable();
            $table->string('link')->nullable();
            $table->string('price')->default(1);
            $table->string('ad_type')->nullable(); //workshop cars sapre parts
            $table->string('appearance_qty')->default(1);
            $table->boolean('is_active')->default(false);
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('views')->default(0);

            $table->unsignedBigInteger(column: 'brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('car_brands')->onDelete('cascade');

            $table->unsignedBigInteger(column: 'user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('allusers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
