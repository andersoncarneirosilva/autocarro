<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
class PagamentosController extends Controller
{
    protected $model;

    public function index(Request $request){

     
        return view('pagamentos.index');
    }

}