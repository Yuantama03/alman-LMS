<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoPembelajaransTable extends Migration
{
    public function up()
    {
        Schema::create('video_pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_section_id')->constrained('video_sections')->onDelete('cascade');
            $table->string('judul');
            $table->string('youtube_url');
            $table->string('durasi')->nullable(); // misal "10 menit"
            $table->integer('urutan')->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_pembelajarans');
    }
}