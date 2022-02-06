<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained();
            $table->string('nama');
            $table->enum('jenis_kelamin',['Perempuan','Laki-laki']);
            $table->char('no_akta',21)->unique();
            $table->char('anak_ke',2);
            $table->char('nik',16)->unique();
            $table->string('alamat');
            $table->char('tempat_lahir',15);
            $table->date('tanggal_lahir');
            $table->foreignId('provinsi_id')->constrained();
            $table->foreignId('kota_kabupaten_id')->constrained();
            $table->foreignId('kecamatan_id')->constrained();
            $table->foreignId('kelurahan_id')->constrained();
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
        Schema::dropIfExists('childrens');
    }
}
