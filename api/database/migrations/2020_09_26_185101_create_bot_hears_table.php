<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotHearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_hears', function (Blueprint $table) {
            $table->id();
            $table->string("hears");
            $table->string("bot_responses_key", 30);
            $table->foreign("bot_responses_key")->references('key')->on("bot_responses"); // refereces("id")->on("bot_responses");
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
        Schema::dropIfExists('bot_hears');
    }
}
