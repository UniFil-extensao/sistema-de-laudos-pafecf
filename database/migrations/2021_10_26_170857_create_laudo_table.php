<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaudoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laudos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_laudo');
            $table->unsignedBigInteger('id_pdv');
            $table->unsignedBigInteger('id_empresa');
            $table->string('ifl');
            $table->string('razao_social_empresa');
            $table->string('nome_comercial_pdv');
            $table->string('homologador');
            $table->string('data_inicio');
            $table->string('data_termino');
            $table->string('versao_er');
            $table->string('envelope_seguranca_marca');
            $table->string('envelope_seguranca_modelo');
            $table->string('numero_envelope');
            $table->string('requisitos_executados_sgbd');
            $table->string('executavel_sgbd');
            $table->string('funcao_sped');
            $table->string('executavel_sped');
            $table->string('executavel_nfe');
            $table->boolean('parecer_conclusivo');
            $table->string('ecf_analise_marca');
            $table->string('ecf_analise_modelo');
            $table->longText('relacao_ecfs_marca');
            $table->longText('relacao_ecfs_modelo');
            $table->string('comentarios')->nullable();
            $table->string('responsavel_testes');
            $table->string('caminho_laudo')->nullable();
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
        Schema::dropIfExists('laudos');
    }
}
