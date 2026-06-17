<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('chat_group_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_group_id')->constrained('chat_groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_group_messages');
    }
}