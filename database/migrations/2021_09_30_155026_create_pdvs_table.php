<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdvs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empresa');
            $table->string('razao_social_empresa');
            $table->string('nome_comercial');
            $table->string('versao');
            $table->string('nome_principal_executavel');
            $table->string('linguagem');
            $table->string('sistema_operacional');
            $table->string('data_base');
            $table->string('tipo_desenvolvimento');
            $table->string('tipo_funcionamento');
            $table->string('nfe');
            $table->string('sped');
            $table->string('nfce');
            $table->string('tratamento_interrupcao');
            $table->string('integracao_paf');
            $table->longText('aplicacoes_especiais');
            $table->longText('forma_impressao');
            $table->longText('perfis');
            $table->boolean('validacao');
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
        Schema::dropIfExists('pdvs');
    }
}
