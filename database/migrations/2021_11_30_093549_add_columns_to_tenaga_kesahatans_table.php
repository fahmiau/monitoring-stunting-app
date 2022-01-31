<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTenagaKesahatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenaga_kesahatans', function (Blueprint $table) {
            $table->string('nama');
            $table->foreignId('kelurahan_id')->constrained();
            $table->enum('kategori',['Bidan','Perawat']);
            $table->string('alamat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenaga_kesahatans', function (Blueprint $table) {
            //
        });
    }
}
