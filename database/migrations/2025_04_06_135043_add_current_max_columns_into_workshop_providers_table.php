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
        //
        Schema::table('workshop_providers', function (Blueprint $table) {
            //
            $table->string('current')->default(0);
            $table->string('max')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('workshop_providers', function (Blueprint $table) {
            //
        });
    }
};
