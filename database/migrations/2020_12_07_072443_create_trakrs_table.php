<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrakrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trakrs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('trakr_id');
            $table->string('phoneNumber');
            $table->string('email')->nullable();
            $table->string('trakr_type_id');
            $table->integer('user_id');
            $table->string('who', 1000)->nullable();
            $table->string('assistance')->nullable();
            $table->integer('form')->nullable();
            $table->string('answers')->nullable();
            $table->string('status')->nullable();
            $table->string('safe')->nullable();
            $table->timestamp('checked_out')->nullable();
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
        Schema::dropIfExists('trakrs');
    }
}
