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
        if (!Schema::hasColumn('sq', 'attn')) {
            Schema::table('sq', function (Blueprint $table) {
                $table->string('attn')->nullable();
            });
        }
        if (!Schema::hasColumn('so', 'attn')) {
            Schema::table('so', function (Blueprint $table) {
                $table->string('attn')->nullable();
            });
        }
        if (!Schema::hasColumn('deli', 'attn')) {
            Schema::table('deli', function (Blueprint $table) {
                $table->string('attn')->nullable();
            });
        }
        if (!Schema::hasColumn('sale', 'attn')) {
            Schema::table('sale', function (Blueprint $table) {
                $table->string('attn')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sq', 'attn')) {
            Schema::table('sq', function (Blueprint $table) {
                $table->dropColumn('attn');
            });
        }
        if (Schema::hasColumn('so', 'attn')) {
            Schema::table('so', function (Blueprint $table) {
                $table->dropColumn('attn');
            });
        }
        if (Schema::hasColumn('deli', 'attn')) {
            Schema::table('deli', function (Blueprint $table) {
                $table->dropColumn('attn');
            });
        }
        if (Schema::hasColumn('sale', 'attn')) {
            Schema::table('sale', function (Blueprint $table) {
                $table->dropColumn('attn');
            });
        }
    }
};
