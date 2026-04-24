<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectAndPriorityToContactMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('subject')->after('email');
            $table->enum('inquiry_type', ['general', 'booking', 'complaint', 'suggestion'])->default('general')->after('subject');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('inquiry_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['subject', 'inquiry_type', 'priority']);
        });
    }
}
