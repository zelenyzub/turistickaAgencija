<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliseOsiguranjaTable extends Migration
{
    public function up()
    {
        Schema::create('polise_osiguranja', function (Blueprint $table) {
            $table->increments('idPolise');
            $table->string('imeNosiocaOsiguranja');
            $table->string('prezimeNosiocaOsiguranja');
            $table->enum('vrstaPolise', ['individualna', 'grupna'])->comment('vrstaPolise moze biti individualna ili grupna');
            $table->string('telefon');
            $table->dateTime('datumPutovanjaOd');
            $table->dateTime('datumPutovanjaDo');
            $table->string('dodatniPodaci')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('polise_osiguranja');
    }
}