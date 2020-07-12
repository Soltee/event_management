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
            $table->UnsignedBigInteger('category_id');
            $table->UnsignedBigInteger('user_id')->nullable();
            $table->string('cover')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sub_title')->nullable();
            $table->decimal('price');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('book_before');
            $table->integer('ticket');
            $table->text('description');
            $table->string('venue_name');
            $table->string('venue_full_address');
            $table->string('venue_latitude');
            $table->string('venue_longitude');
            $table->timestamps();;
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
