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
        Schema::table('carlisting', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('feature_id')->nullable();
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carlistings', function (Blueprint $table) {
            //
        });
    }
};
