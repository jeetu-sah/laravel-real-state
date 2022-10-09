<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpcietyRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('spciety_rooms')) {
            Schema::create('spciety_rooms', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('society_id')->nullable();
                $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade')->onUpdate('cascade');
                $table->string('title',200)->nullable();
                $table->string('room_area')->nullable();
                $table->double('plot_size_by_gaj',8,2)->default(0);
                $table->double('plot_value',8,2)->default(0);
                $table->integer('number_of_plot')->default(0);
                $table->softDeletes();
                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spciety_rooms');
    }
}
