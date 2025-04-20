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
        Schema::table('allusers', function (Blueprint $table) {
            //
            $table->string('packages_price')->nullable();
            $table->string('packages_deadline')->nullable();
            $table->boolean('packages_renew')->default(true);
            $table->string('packages_queue')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('allusers', function (Blueprint $table) {
            //
        });
    }
};
