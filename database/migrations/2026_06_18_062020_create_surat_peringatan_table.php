<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratPeringatanTable extends Migration
{
    public function up()
    {
        Schema::create('surat_peringatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->enum('level', ['SP1', 'SP2', 'SP3']);
            $table->integer('poin_saat_sp'); // total poin pelanggaran saat SP diterbitkan
            $table->enum('status', ['Aktif', 'Selesai'])->default('Aktif');
            $table->text('keterangan')->nullable();
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_peringatan');
    }
}