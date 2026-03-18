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
        Schema::create('prcvd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prcv_id');
            $table->smallInteger('dno');
            $table->unsignedBigInteger('item_id');
            $table->string('itemname');
            $table->decimal('qty', 19, 4)->default(0);
            $table->string('unit');
            $table->decimal('conv', 19, 4)->default(0);
            $table->decimal('qtyx', 19, 4)->default(0);
            $table->decimal('cost', 19, 4)->default(0);
            $table->decimal('baseprice', 19, 4)->default(0);
            $table->decimal('listprice', 19, 4)->default(0);
            $table->string('discexp')->nullable();
            $table->decimal('discamt', 19, 4)->default(0);
            $table->decimal('totaldiscamt', 19, 4)->default(0);
            $table->decimal('disc2amt', 19, 4)->default(0);
            $table->decimal('totaldisc2amt', 19, 4)->default(0);
            $table->decimal('subtotal', 19, 4)->default(0);
            $table->decimal('basesubtotal', 19, 4)->default(0);
            $table->text('dnote')->nullable();
            $table->string('tax_code')->nullable();
            $table->decimal('taxableamt', 19, 4)->default(0);
            $table->decimal('taxamt', 19, 4)->default(0);
            $table->decimal('totaltaxamt', 19, 4)->default(0);
            $table->decimal('basetotaltaxamt', 19, 4)->default(0);
            $table->decimal('basefistotaltaxamt', 19, 4)->default(0);

            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prcvd');
    }
};
