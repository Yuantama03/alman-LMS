<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sp_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->enum('level_sp', ['SP 1', 'SP 2', 'SP 3']); // SP 1, SP 2, SP 3
            $table->integer('poin_saat_sp'); // Poin saat SP diberikan
            $table->date('tanggal_sp');
            $table->enum('status', ['Aktif', 'Belum Ada', 'Revoked'])->default('Aktif'); // Status SP
            $table->text('alasan')->nullable();
            $table->date('tanggal_release')->nullable(); // Tanggal SP dicabut (untuk SP 1 bisa dicabut)
            $table->string('created_by')->nullable(); // User yang membuat
            $table->timestamps();
            
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_siswas');
    }
};