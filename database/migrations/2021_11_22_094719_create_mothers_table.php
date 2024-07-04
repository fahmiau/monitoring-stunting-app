<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMothersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mothers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('nama');
            $table->char('nik',16)->unique();
            $table->char('golongan_darah',2);
            $table->char('pendidikan',5);
            $table->char('pekerjaan',50);
            $table->foreignId('kelurahan_id')->constrained();
            $table->foreignId('kecamatan_id')->constrained();
            $table->foreignId('kota_kabupaten_id')->constrained();
            $table->foreignId('provinsi_id')->constrained();
            $table->string('alamat');
            $table->char('nomor_telepon',15);
            $table->char('tempat_lahir',30);
            $table->date('tanggal_lahir');
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
        Schema::dropIfExists('mothers');
    }
}
