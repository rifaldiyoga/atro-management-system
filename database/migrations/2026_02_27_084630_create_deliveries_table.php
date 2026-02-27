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
    Schema::create('deli', function (Blueprint $table) {
      $table->id();
      $table->string('trxno');
      $table->timestampTz('trxdate');
      $table->unsignedBigInteger('branch_id')->nullable();
      $table->unsignedBigInteger('bp_id');
      $table->string('reftype')->nullable();
      $table->unsignedBigInteger('refid')->nullable(); // so_id reference
      $table->string('trxtype')->nullable();
      $table->bigInteger('version')->default(1);
      $table->boolean('isdraft')->default(false);
      $table->boolean('isvoid')->default(false);
      $table->string('status')->nullable();
      $table->text('note')->nullable();
      $table->boolean('active')->default(true);
      $table->unsignedBigInteger('created_by');
      $table->unsignedBigInteger('updated_by');
      $table->text('billaddr');
      $table->text('shipaddr');
      $table->unsignedBigInteger('srep_id')->nullable();
      $table->unsignedBigInteger('ship_id')->nullable();
      $table->timestampTz('reqdtime')->nullable();   // requested delivery time
      $table->timestampTz('shiptime')->nullable();   // actual ship/delivery time
      $table->text('note_emp')->nullable();
      $table->string('reserved_var1')->nullable();
      $table->string('reserved_var2')->nullable();
      $table->string('reserved_var3')->nullable();
      $table->integer('reserved_int1')->nullable();
      $table->integer('reserved_int2')->nullable();
      $table->integer('reserved_int3')->nullable();
      $table->decimal('reserved_num1', 19, 4)->nullable();
      $table->decimal('reserved_num2', 19, 4)->nullable();
      $table->decimal('reserved_num3', 19, 4)->nullable();
      $table->boolean('isautogen')->default(false);

      $table->timestampsTz();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('deli');
  }
};
