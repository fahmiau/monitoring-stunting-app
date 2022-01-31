<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeightGirlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('height_girls', function (Blueprint $table) {
            $table->id();
            $table->integer('months');
            $table->float('-3sd');
            $table->float('-2sd');
            $table->float('-1sd');
            $table->float('median');
            $table->float('1sd');
            $table->float('2sd');
            $table->float('3sd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('height_girls');
    }
}
