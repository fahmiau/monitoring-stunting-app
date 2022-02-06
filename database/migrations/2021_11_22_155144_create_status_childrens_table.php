<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_childrens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('children_id')->constrained();
            $table->foreignId('provinsi_id')->constrained();
            $table->foreignId('kota_kabupaten_id')->constrained();
            $table->foreignId('kecamatan_id')->constrained();
            $table->foreignId('kelurahan_id')->constrained();
            $table->enum('status_stunting',['Dibawah Standar','Diatas Standar','Normal']);
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
        Schema::dropIfExists('status_childrens');
    }
}
