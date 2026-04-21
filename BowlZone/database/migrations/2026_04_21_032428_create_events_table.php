<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('event_name');
            $table->date('event_date');
            $table->string('venue');
            $table->decimal('price_per_pax', 10, 2);
            $table->string('phone', 20);
            $table->unsignedInteger('participants');
            $table->decimal('total_paid', 10, 2);
            $table->timestamps();

            $table->index(['user_id', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
