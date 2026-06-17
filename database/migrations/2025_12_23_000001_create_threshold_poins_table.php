<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThresholdPoinsTable extends Migration
{
    public function up()
    {
        Schema::create('threshold_poins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->integer('sangat_baik')->default(90);
            $table->integer('baik')->default(75);
            $table->integer('cukup')->default(60);
            $table->integer('kurang')->default(40);
            $table->timestamps();

            $table->unique('kelas_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('threshold_poins');
    }
}