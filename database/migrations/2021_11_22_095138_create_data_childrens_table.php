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
            $table->char('bulan_ke',2);
            $table->char('tempat',20);
            $table->float('berat_badan');
            $table->float('panjang_badan');
            $table->float('lingkar_kepala');
            $table->char('perkembangan',10)->nullable();
            $table->boolean('kie')->nullable();
            $table->boolean('imunisasi')->nullable();
            $table->boolean('vitamin_a')->nullable();
            $table->boolean('obat_cacing')->nullable();
            $table->boolean('ppia')->nullable();
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
