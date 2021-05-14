<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastroEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->string('cnpj', 18);
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('endereco');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf', 2);
            $table->string('cep', 9);
            $table->string('telefone', 15);
            $table->string('celular', 14);
            $table->string('inscricao_estadual');
            $table->string('inscricao_municipal');
            $table->string('representante');
            $table->string('cpf_representante', 14);
            $table->string('rg_representante', 12);
            $table->string('email_representante');
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
        Schema::dropIfExists('empresas');
    }
}