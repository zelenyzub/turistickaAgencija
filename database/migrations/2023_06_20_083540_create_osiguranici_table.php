<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsiguraniciTable extends Migration
{
    public function up()
    {
        Schema::create('osiguranici', function (Blueprint $table) {
            $table->increments('idOsiguranika');
            $table->integer('idPolise')->unsigned();
            $table->string('ime');
            $table->string('prezime');
            $table->date('datumRodjenja');
            $table->timestamps();

            $table->foreign('idPolise')->references('idPolise')->on('polise_osiguranja')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    public function down()
    {
        Schema::dropIfExists('osiguranici');
    }
}
