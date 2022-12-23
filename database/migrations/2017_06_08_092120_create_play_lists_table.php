_<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('play_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->enum('aspect_ratio', ['16*9', '16*10','4*3','9*16'])->default('16*9');
            $table->enum('layout', ['1', '1/2','1*2','1*2/3'])->default('1');
            $table->string('screen_resolution')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('user_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('play_lists');
    }
}
