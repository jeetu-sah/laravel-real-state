<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlotPaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('plot_payment_histories')) {

             Schema::create('plot_payment_histories', function (Blueprint $table) {
                 $table->id();
                 $table->unsignedBigInteger('society_plots_number_id')->nullable();
                 $table->foreign('society_plots_number_id')->references('id')->on('society_plots_numbers');
                 $table->unsignedBigInteger('payment_holder_id')->nullable();
                 $table->foreign('payment_holder_id')->references('id')->on('users');
                 $table->string('buyer_name')->nullable();
                 $table->integer('payment_method');
                 $table->string('reference_number',50);
                 $table->double('paid_amount',8,2)->nullable();
                 $table->double('remain_amount',8,2)->nullable();
                 $table->datetime('paid_amount_date');
                 $table->text('payment_file')->nullable();
                 $table->text('bank_detail')->nullable();
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
        Schema::dropIfExists('plot_payment_histories');
    }
}
