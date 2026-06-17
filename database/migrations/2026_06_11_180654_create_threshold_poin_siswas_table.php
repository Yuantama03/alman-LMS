<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThresholdPoinSiswasTable extends Migration
{
    public function up()
    {
        Schema::create('threshold_poin_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->integer('sangat_baik')->default(90);
            $table->integer('baik')->default(75);
            $table->integer('cukup')->default(60);
            $table->integer('kurang')->default(40);
            $table->foreignId('set_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique('siswa_id'); // 1 siswa = 1 threshold
        });
    }

    public function down()
    {
        Schema::dropIfExists('threshold_poin_siswas');
    }
}