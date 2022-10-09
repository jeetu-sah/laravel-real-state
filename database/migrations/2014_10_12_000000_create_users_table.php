<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('f_name',50);
            $table->string('l_name',50);
            $table->string('user_name');
            $table->string('provider',100)->nullable();
            $table->string('provider_id',100)->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->bigInteger('mobile')->unique()->nullable();
            $table->string('password');
            $table->integer('roll_id')->default(1);
            $table->char('user_status',1)->default("P");
            $table->string('device_id')->nullable();
            $table->text('device_token')->nullable();
            $table->string('referel_code')->nullable();
            $table->string('own_referal_code')->nullable();
            $table->timestamp('dob')->nullable();
            $table->double('wallet_amount',8,2)->default(0);
            $table->boolean('term_and_condition_status',[0,1])->default(1);
            $table->boolean('is_signed',[0,1]);
            $table->string('description')->nullable();
            $table->string('user_id')->nullable();;
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
