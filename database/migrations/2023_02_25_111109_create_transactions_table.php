<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('reference_id')->unique();
            $table->string('merchant_reference')->nullable();
            $table->string('channel')->default('online');
            $table->unsignedDecimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('status_code')->nullable();
            $table->string('currency')->default('GHS');
            $table->string('callback_url')->nullable();
            $table->string('return_url')->nullable();
            $table->string('cancel_url')->nullable();
            //meta data field to store details such as checkout id, checkout url, checkout direct url and other details in json format
            $table->json('meta_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
