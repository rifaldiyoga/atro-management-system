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
        Schema::table('business_partners', function (Blueprint $table) {
            // Menambahkan kolom email setelah kolom 'phone'
            // Kolom ini bisa dikosongkan (nullable) dan harus unik
            $table->string('email')->nullable()->unique()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_partners', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
