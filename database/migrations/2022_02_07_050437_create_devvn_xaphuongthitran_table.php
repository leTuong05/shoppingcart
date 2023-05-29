<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevvnXaphuongthitranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devvn_xaphuongthitran', function (Blueprint $table) {
            $table->id();
            $table->integer('xaid');
            $table->string('name');
            $table->string('type');
            $table->integer('maqh');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devvn_xaphuongthitran');
    }
}
