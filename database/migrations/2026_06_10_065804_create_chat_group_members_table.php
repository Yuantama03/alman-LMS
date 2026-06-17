<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupMembersTable extends Migration
{
    public function up()
    {
        Schema::create('chat_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_group_id')->constrained('chat_groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->timestamps();

            $table->unique(['chat_group_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_group_members');
    }
}