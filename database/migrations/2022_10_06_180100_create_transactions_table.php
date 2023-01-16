<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('type_id');
                $table->foreign('type_id')->references('id')->on('types');
            $table->unsignedInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories');
            $table->string('note')->nullable();
            $table->double('amount');
            $table->timestamp('date_transact');
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
        Schema::dropIfExists('transactions');
    }
};
