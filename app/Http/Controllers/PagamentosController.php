<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagamentosController extends Controller
{
    protected $model;

    public function index(Request $request){

     
        return view('pagamentos.index');
    }

}