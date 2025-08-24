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
        // Change notes field to text in orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->text('notes')->nullable()->change();
        });

        // Change notes field to text in offer_requests table
        Schema::table('offer_requests', function (Blueprint $table) {
            $table->text('notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert notes field back to string in orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->string('notes')->nullable()->change();
        });

        // Revert notes field back to string in offer_requests table
        Schema::table('offer_requests', function (Blueprint $table) {
            $table->string('notes')->nullable()->change();
        });
    }
};
