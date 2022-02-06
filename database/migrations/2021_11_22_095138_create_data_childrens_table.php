<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_childrens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('children_id')->constrained();
            $table->date('tanggal');
            $table->unsignedInteger('bulan_ke');
            $table->char('tempat',20);
            $table->float('berat_badan');
            $table->float('panjang_badan');
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
        Schema::dropIfExists('data_childrens');
    }
}
