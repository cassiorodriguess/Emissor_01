<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
           
            $table->id();
            $table->string('nome_razao_social',100);
            $table->string('nome_fantasia',100);
            $table->string('cpf_cnpj',18);
            $table->string('inscricao_estadual',15);
            $table->string('codigo_cidade',15);
            $table->string('logradouro');
            $table->string('numero',10);
            $table->string('complemento');
            $table->string('bairro');
            $table->string('cidade',80);
            $table->string('certificado');
            $table->string('senha_certificado');
            $table->string('cep',20);
            $table->string('email',70);
            $table->string('telefone',20);
            $table->string('celular',20);
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
};
