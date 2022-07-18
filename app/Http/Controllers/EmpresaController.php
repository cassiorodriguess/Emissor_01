<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class EmpresaController extends BaseController
{        

    public function __construct(){
        $this->middleware('auth:api');
    }

    // Constantes definidas apenas para este controller

    const STATUS = [
        'SUCCESS' => 200, 
        'ERROR' => 500,
        'NOT_FOUND' => 400
    ];

    const STATUS_EMPRESA = [
        'ATIVO' => 1, 
        'CANCELADA' => 0
    ];

    public function listEmpresas(){
        
        $empresa = DB::table('empresas')
            ->where('status','<>',self::STATUS_EMPRESA['CANCELADA'])
            ->get();

        return response()->json($empresa);
    }

    public function inserirEmpresa(Request $request){
      
        try {
            $request->validate([
                'cpf_cnpj' => 'required|unique:empresas',
                'nome_razao_social' => 'required|unique:empresas',
            ]);
            $empresa = Empresa::create($request->all());
        } catch (Exception $e) {
    
            $erro = [
                'status' => 'error',
                'message' =>  'Ocorreu um erro ao tentar inserir esta empresa. '.$e->getMessage()
            ];
            return response()->json($erro,self::STATUS['ERROR']);
        }
        
        $dados = [
            'status' => 'success',
            'message' => 'Empresa criada com sucesso',
            'empresa' => $empresa
        ];

        return response()->json($dados,self::STATUS['SUCCESS']);
    }

    public function getEmpresa($id){
        
        if(empty($id)){
            
            $erro = [
                'status' => 'error',
                'message' =>  'O código do registro não pode estar vazio .'
            ];

            return response()->json($erro,self::STATUS['NOT_FOUND']);
        }
  
        $empresa = Empresa::find($id);
        
        if(empty($empresa)){
      
            $erro = [
                'status' => 'error',
                'message' =>  'Registro inexistente.'
            ];
        
            return response()->json($erro,self::STATUS['NOT_FOUND']);
        }

        if($empresa->status == self::STATUS_EMPRESA['CANCELADA']){
            
            $erro = [
                'status' => 'success',
                'message' =>  'Esta empresa se encontra cancelada.'
            ];
        
            return response()->json($erro,self::STATUS['SUCCESS']);
        }

        return response()->json($empresa,self::STATUS['SUCCESS']);

    }

    public function updateEmpresa(Request $request,$id){
        
        if(empty($id)){
            $erro = [
                'status' => 'error',
                'message' =>  'O código do registro não pode estar vazio .'
            ];

            return response()->json($erro,self::STATUS['NOT_FOUND']);
        }
     
        if(empty($request->all())){
            $erro = [
                'status' => 'error',
                'message' =>  'Dados para atualizar os registros não podem estar vazios.'
            ];

            return response()->json($erro,self::STATUS['NOT_FOUND']);
        }
     
        $empresa = Empresa::find($id);

        if(empty($empresa)){
      
            $erro = [
                'status' => 'error',
                'message' =>  'Registro inexistente.'
            ];
        
            return response()->json($erro,self::STATUS['NOT_FOUND']);
        }

        if($empresa->status == self::STATUS_EMPRESA['CANCELADA']){
            
            $erro = [
                'status' => 'success',
                'message' =>  'Esta empresa se encontra cancelada.'
            ];
        
            return response()->json($erro,self::STATUS['SUCCESS']);
        }

        $empresa->nome_razao_social = $request->nome_razao_social;
        $empresa->nome_fantasia = $request->nome_fantasia;
        $empresa->cpf_cnpj = $request->cpf_cnpj;
        $empresa->inscricao_estadual = $request->inscricao_estadual;
        $empresa->codigo_cidade = $request->codigo_cidade;
        $empresa->logradouro = $request->logradouro;
        $empresa->numero = $request->numero;
        $empresa->complemento = $request->complemento;
        $empresa->bairro = $request->bairro;
        $empresa->cidade = $request->cidade;
        $empresa->certificado = $request->certificado;
        $empresa->senha_certificado = $request->senha_certificado;
        $empresa->cep = $request->cep;
        $empresa->email = $request->email;
        $empresa->telefone = $request->telefone;
        $empresa->celular = $request->celular;
        $empresa->save();

        return response()->json($empresa,self::STATUS['SUCCESS']);

    }

    public function cancelEmpresa($id){
                
        if(empty($id)){
            $erro = [
                'status' => 'error',
                'message' =>  'O código do registro não pode estar vazio.'
            ];

            return response()->json($erro,self::STATUS['ERROR']);
        }
     
        $empresa = Empresa::find($id);
        
        if(empty($empresa)){
            $erro = [
                'status' => 'error',
                'message' =>  'Registro inexistente.'
            ];

            return response()->json($erro,self::STATUS['NOT_FOUND']);
        }

        if($empresa->status == self::STATUS_EMPRESA['CANCELADA']){
            
            $erro = [
                'status' => 'error',
                'message' =>  'Esta empresa já se encontra cancelada há algum tempo.'
            ];
        
            return response()->json($erro,self::STATUS['ERROR']);
        }


        $empresa->status = self::STATUS_EMPRESA['CANCELADA'];
        $empresa->save();

        if(empty($empresa)){

            $cancel = [
                'status' => 'error',
                'message' =>  'Não foi possível cancelar esta empresa.'
            ];
    
            return response()->json($cancel,self::STATUS['ERROR']);
        }

        $cancel = [
            'status' => 'success',
            'message' =>  'Empresa cancelada.'
        ];

        return response()->json($cancel,self::STATUS['SUCCESS']);
    }

}
