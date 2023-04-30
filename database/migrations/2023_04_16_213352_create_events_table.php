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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->enum("type", ['gól', "öngól", "sárga lap", "piros lap"]);
            $table->integer("minute");

            $table->unsignedBigInteger("game_id")->nullable();
            $table->unsignedBigInteger("player_id")->nullable();

            $table
                ->foreign("game_id")
                ->references("id")
                ->on("games")
                ->onDelete("cascade");
            $table
                ->foreign("player_id")
                ->references("id")
                ->on("players")
                ->onDelete("cascade");

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
        Schema::dropIfExists('events');
    }
};
