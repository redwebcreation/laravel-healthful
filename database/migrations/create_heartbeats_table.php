<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHeartbeatsTable extends Migration
{
    public function up()
    {
        Schema::create('heartbeats', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('type')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('heartbeats');
    }
}
