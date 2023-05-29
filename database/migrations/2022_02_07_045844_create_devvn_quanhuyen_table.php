<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevvnQuanhuyenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devvn_quanhuyen', function (Blueprint $table) {
            $table->id();
            $table->integer('maqh');
            $table->string('name');
            $table->string('type');
            $table->integer('matp');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devvn_quanhuyen');
    }
}
