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
    Schema::create('items', function (Blueprint $table) {
      $table->id();
      $table->string('code')->unique();
      $table->string('name');
      $table->string('taxcode')->nullable();

      $table->string('unit')->default('EA');

      $table->decimal('price', 15, 2)->default(0.00);
      $table->string('discexp')->nullable();
      $table->decimal('lastpurcprice', 15, 2)->default(0.00);
      $table->text('description')->nullable();
      $table->string('itemtype')->default('GOOD'); // GOOD, SERV, MFG, RAW
      $table->boolean('active')->default(true);
      $table->longText('photo_url')->nullable();

      $table->timestampsTz();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('items');
  }
};
