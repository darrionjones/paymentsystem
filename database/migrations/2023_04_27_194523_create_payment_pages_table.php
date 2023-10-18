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
        Schema::create('payment_pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ussd_extension')->nullable();
            $table->unsignedBigInteger('merchant_id');
            $table->string('page_name');
            $table->text('page_description');
            $table->string('image')->nullable();
            $table->string('payment_type')->default('one-time');
            $table->timestamps();

            $table->foreign('merchant_id')->references('id')->on('merchants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_pages');
    }
};
