<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoSearchesTable extends Migration
{
    public function up()
    {
        Schema::create('video_searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mapel_id')->nullable()->constrained('mapels')->onDelete('cascade');
            $table->string('keyword');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_searches');
    }
}