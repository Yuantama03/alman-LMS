<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSilabusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('silabus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mapel_id')->unsigned();
            $table->bigInteger('kelas_id')->unsigned();
            $table->bigInteger('semester_id')->unsigned();
            $table->text('deskripsi')->nullable();
            $table->text('kompetensi_dasar')->nullable();
            $table->text('tujuan_pembelajaran')->nullable();
            $table->text('materi_pokok')->nullable();
            $table->text('metode_pembelajaran')->nullable();
            $table->integer('alokasi_waktu')->nullable(); // dalam menit
            $table->timestamps();

            // Relation Tables
            $table->foreign('mapel_id')->references('id')->on('mapels')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('silabus');
    }
}
