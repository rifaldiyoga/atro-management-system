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
    Schema::table('sq', function (Blueprint $table) {
      $table->string('valid_days')->nullable();
      $table->string('ship_eta')->nullable();
      $table->string('pay_due_period')->nullable();
    });

    Schema::table('so', function (Blueprint $table) {
      $table->string('valid_days')->nullable();
      $table->string('ship_eta')->nullable();
      $table->string('pay_due_period')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('sq', function (Blueprint $table) {
      $table->dropColumn(['valid_days', 'ship_eta', 'pay_due_period']);
    });

    Schema::table('so', function (Blueprint $table) {
      $table->dropColumn(['valid_days', 'ship_eta', 'pay_due_period']);
    });
  }
};
