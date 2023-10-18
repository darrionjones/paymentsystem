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
        Schema::table('transactions', function (Blueprint $table) {
            //add payment_page_id column to transactions table as a foreign key and make it nullable
            $table->uuid('payment_page_id')->nullable()->after('amount');
            $table->foreign('payment_page_id')->references('id')->on('payment_pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //drop payment_page_id column from transactions table
            $table->dropForeign(['payment_page_id']);
        });
    }
};
