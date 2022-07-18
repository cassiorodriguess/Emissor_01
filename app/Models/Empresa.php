<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_razao_social',
        'nome_fantasia',
        'cpf_cnpj',
        'inscricao_estadual',
        'codigo_cidade',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'certificado',
        'senha_certificado',
        'cep',
        'email',
        'telefone',
        'celular',
        'status',
        'observacao' 
    ];
}
