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
        Schema::create('ussd_requests', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 50);
            $table->string('user_id', 50);
            $table->string('msisdn', 50);
            $table->string('ussd_body', 200);
            $table->integer('menu_level');
            $table->json('session_data')->nullable();
            $table->timestamps();
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ussd_requests');
        // $table->dropIndex('session_id');
    }
};
