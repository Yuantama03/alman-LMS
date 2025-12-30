<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKalenderAkademiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kalender_akademiks', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('jenis_kegiatan', [
                'Libur',
                'Ujian',
                'Acara',
                'Pendaftaran',
                'Pembelajaran',
                'Lainnya'
            ])->default('Lainnya');
            $table->string('warna', 7)->default('#3788d8'); // Hex color code
            $table->bigInteger('semester_id')->unsigned()->nullable();
            $table->timestamps();

            // Relation Tables
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kalender_akademiks');
    }
}
