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
        Schema::create('itemsupplier', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('bp_id');
            $table->string('vitemcode')->nullable();
            $table->smallInteger('leadtime')->nullable();
            $table->smallInteger('delivetime')->nullable();
            $table->smallInteger('esttime')->nullable();
            $table->boolean('isdefault')->default(false)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestampsTz();

            $table->primary(['item_id', 'bp_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemsupplier');
    }
};
