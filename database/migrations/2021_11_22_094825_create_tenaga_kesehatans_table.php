<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenagaKesehatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenaga_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->char('nik',16)->unique();
            $table->foreignId('kelurahan_id')->constrained();
            $table->foreignId('kecamatan_id')->constrained();
            $table->foreignId('kota_kabupaten_id')->constrained();
            $table->foreignId('provinsi_id')->constrained();
            $table->string('alamat');
            $table->char('nomor_telepon',15);
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
        Schema::dropIfExists('tenaga_kesehatans');
    }
}
