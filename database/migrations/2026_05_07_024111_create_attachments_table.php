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
        Schema::create('attachment', function (Blueprint $table) {
            $table->id();
            $table->string('reftype');
            $table->unsignedBigInteger('refid');
            $table->string('bucket')->nullable();
            $table->string('objkey')->nullable();
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at');
            $table->unsignedBigInteger('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment');
    }
};
