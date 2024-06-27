<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempatKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempat_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->char('tempat_kerja',255);
            $table->char('nomor_telepon_kerja',15);
            $table->char('alamat_kerja',255);
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
        Schema::dropIfExists('tempat_kerjas');
    }
}
