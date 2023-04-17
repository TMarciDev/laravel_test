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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('text');

            $table->unsignedBigInteger("author_id")->nullable();
            $table->unsignedBigInteger("item_id")->nullable();
            $table->timestamps();

            $table
                ->foreign("author_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table
                ->foreign("item_id")
                ->references("id")
                ->on("items")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
// TODO: delete this
