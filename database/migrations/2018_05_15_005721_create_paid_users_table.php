<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('paid_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chances_id')->unsigned()->nullable(true);
            $table->foreign('chances_id')->references('id')->on('chances');
            $table->integer('users_id')->unsigned()->nullable(true);
            $table->foreign('users_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('paid_users');
    }

}
