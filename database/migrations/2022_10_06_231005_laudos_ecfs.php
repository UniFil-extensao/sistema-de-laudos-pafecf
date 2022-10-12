<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaudosEcfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('laudos_ecfs', function (Blueprint $table) {
            // auxiliar table that reference laudos, marcas and modelos
            $table->id();
            $table->unsignedBigInteger('laudo_id');
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('modelo_id');
            //foreign keys
            $table->foreign('laudo_id')->references('id')->on('laudos');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('modelo_id')->references('id')->on('modelos');
            $table->timestamps();
        });
    }
    //php artisan command to run only this migration
    //php artisan migrate --path=/database/migrations/2022_10_06_231004_laudos_ecfs.php

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laudos_ecfs');
    }
}
