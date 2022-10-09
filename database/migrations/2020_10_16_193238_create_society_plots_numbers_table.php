<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocietyPlotsNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('society_plots_numbers')) {
            Schema::create('society_plots_numbers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('society_id')->nullable();
                $table->foreign('society_id')->references('id')->on('societies')->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedBigInteger('society_plot_id')->nullable();
                $table->foreign('society_plot_id')->references('id')->on('spciety_rooms')->onDelete('cascade')->onUpdate('cascade');
                $table->string('plot_number',200)->nullable();
                $table->double('plot_value',8,2)->default(0);
                $table->char('booking_status',1)->default(0);
    
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->string('buyer_name',200)->nullable();
    
                $table->datetime('booking_date');
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
        Schema::dropIfExists('society_plots_numbers');
    }
}
