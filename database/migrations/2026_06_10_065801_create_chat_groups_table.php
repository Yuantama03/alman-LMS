<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('chat_groups', function (Blueprint $table) {
            $table->id();
            $table->string('nama_grup');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_groups');
    }
}