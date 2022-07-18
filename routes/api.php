<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(EmpresaController::class)->group(function () {
    Route::get('empresas', 'listEmpresas');
    Route::post('empresa','inserirEmpresa');
    Route::get('empresa/{id}','getempresa');
    Route::put('empresa/{id}','updateEmpresa');
    Route::delete('empresa/{id}','cancelEmpresa');
}); 

Route::get('welcome',function(){
    return view('welcome');
})->name('welcome');