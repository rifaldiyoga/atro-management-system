<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessPartnersTable extends Migration
{
    public function up(): void
    {
        Schema::create('bp', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->bigInteger('version')->nullable();
            $table->string('bankname')->nullable();
            $table->string('bankaccno')->nullable();
            $table->string('bankaccname')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('note')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('cmpname')->nullable();
            $table->enum('bptype', ['CUST', 'VEND']);

            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bp');
    }
}

