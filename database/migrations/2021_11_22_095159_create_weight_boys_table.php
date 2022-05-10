<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightBoysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_boys', function (Blueprint $table) {
            $table->id();
            $table->integer('months');
            $table->float('negative_3sd');
            $table->float('negative_2sd');
            $table->float('negative_1sd');
            $table->float('median');
            $table->float('positive_1sd');
            $table->float('positive_2sd');
            $table->float('positive_3sd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weight_boys');
    }
}
