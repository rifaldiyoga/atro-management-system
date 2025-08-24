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
        Schema::table('offer_requests', function (Blueprint $table) {
            // Menambahkan kolom status setelah rfq_duration
            $table->string('status')->default('pending')->after('rfq_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
