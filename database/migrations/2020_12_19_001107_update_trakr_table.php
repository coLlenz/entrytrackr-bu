<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTrakrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trakrs', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trakrs', function (Blueprint $table) {
            $table->dropColumn('checked_out');
            $table->tinyInteger('checked_in_status')->after('date_marked_safe')->nullable();
            $table->dateTime('checked_in_date')->nullable();
            $table->dateTime('checked_out_date')->nullable();
        });
    }
}
