<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoinSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poin_siswas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('siswa_id')->unsigned();
            $table->enum('jenis', ['Prestasi', 'Pelanggaran'])->default('Prestasi');
            $table->string('kategori');
            $table->text('deskripsi');
            $table->integer('poin'); // Positif untuk prestasi, negatif untuk pelanggaran
            $table->date('tanggal');
            $table->bigInteger('created_by')->unsigned();
            $table->timestamps();

            // Foreign keys
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poin_siswas');
    }
}
