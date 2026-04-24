<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_message_id')->constrained('contact_messages')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->text('reply_message');
            $table->timestamps();
        });

        // Add status and is_read columns to contact_messages
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('message'); // pending, read, solved
            $table->boolean('is_read')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_replies');

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['status', 'is_read']);
        });
    }
}
