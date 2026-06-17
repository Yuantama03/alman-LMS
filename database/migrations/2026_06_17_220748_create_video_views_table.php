<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoViewsTable extends Migration
{
    public function up()
    {
        Schema::create('video_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_pembelajaran_id')->constrained('video_pembelajarans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedInteger('jumlah_tonton')->default(1);
            $table->timestamps();
            $table->unique(['video_pembelajaran_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_views');
    }
}