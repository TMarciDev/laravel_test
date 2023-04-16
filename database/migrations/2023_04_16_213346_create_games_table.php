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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->dateTime("start");
            $table->boolean("finished");

            $table->unsignedBigInteger("home_team_id")->nullable();
            $table->unsignedBigInteger("away_team_id")->nullable();

            $table
                ->foreign("home_team_id")
                ->references("id")
                ->on("teams")
                ->onDelete("cascade");

            $table
                ->foreign("away_team_id")
                ->references("id")
                ->on("teams")
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
        Schema::dropIfExists('games');
    }
};
