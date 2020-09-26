<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_responses', function (Blueprint $table) {
            $table->string("key", 30)->index();
            $table->string("server_action", 50)->nullable();
            $table->string("client_action", 50)->nullable();
            $table->string("next_step", 30)->nullable();
            $table->string("message")->nullable();
            $table->primary("key");
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
        Schema::dropIfExists('bot_responses');
    }
}
