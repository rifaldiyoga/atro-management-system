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
    Schema::create('sale', function (Blueprint $table) {
      $table->id();
      $table->string('trxno');
      $table->timestampTz('trxdate');
      $table->unsignedBigInteger('branch_id')->nullable();
      $table->unsignedBigInteger('bp_id');
      $table->string('reftype')->nullable();        // e.g. 'SO'
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
      $table->boolean('taxed')->default(false);
      $table->boolean('taxinc')->default(false);
      $table->text('billaddr');
      $table->text('shipaddr');
      $table->unsignedBigInteger('srep_id')->nullable();
      $table->decimal('subtotal', 19, 4)->default(0);
      $table->decimal('basesubtotal', 19, 4)->default(0);
      $table->string('discexp')->nullable();
      $table->decimal('discamt', 19, 4)->default(0);
      $table->decimal('basediscamt', 19, 4)->default(0);
      $table->decimal('taxamt', 19, 4)->default(0);
      $table->decimal('basetaxamt', 19, 4)->default(0);
      $table->decimal('basefistaxamt', 19, 4)->default(0);
      $table->decimal('total', 19, 4)->default(0);
      $table->decimal('basetotal', 19, 4)->default(0);
      $table->decimal('dpamt', 19, 4)->default(0);
      $table->unsignedBigInteger('ship_id')->nullable();
      $table->string('valid_days')->nullable();
      $table->string('ship_eta')->nullable();
      $table->string('pay_due_period')->nullable();
      $table->timestampTz('due_date')->nullable();    // payment due date
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
      $table->timestampTz('reqdtime')->nullable();
      $table->text('note_emp')->nullable();

      $table->timestampsTz();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sale');
  }
};
