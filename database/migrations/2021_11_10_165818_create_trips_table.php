<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('going')->constrained('governorates');
            $table->foreignId('coming')->constrained('governorates');
            $table->date('trip_date');
            $table->time('take_time');
            $table->time('arrival_time');
            $table->foreignId('driver')->constrained('users');
            $table->integer('number_of_seats');
            $table->integer('available_seats');
            $table->integer('ticket_price');
            $table->integer('car_nymber');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
