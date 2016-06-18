<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurpleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purple', function(Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 50);
            $table->string('uri', 100);
            $table->text('content');
            $table->float('time');
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
        Schema::drop('purple');
    }
}
