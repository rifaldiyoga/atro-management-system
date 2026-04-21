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
        Schema::create('itgrp', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('name', 125);
            $table->smallInteger('level');
            $table->unsignedBigInteger('up_id')->nullable();
            $table->string('itemtype_code', 25);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps(); // creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itgrp');
    }
};
