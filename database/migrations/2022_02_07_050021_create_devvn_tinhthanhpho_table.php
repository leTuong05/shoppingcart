<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevvnTinhthanhphoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devvn_tinhthanhpho', function (Blueprint $table) {
            $table->id();
            $table->integer('matp');
            $table->string('name');
            $table->string('type');
            $table->string('slug');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devvn_tinhthanhpho');
    }
}
