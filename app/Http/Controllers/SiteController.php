<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;
use Parsedown;

class SiteController extends Controller
{
    protected $model;

    public function __construct(Veiculo $veiculos)
    {
        $this->model = $veiculos;
    }

    public function index(Request $request)
    {

        $veiculos = Veiculo::paginate(10);
        //dd($texts);

        // dd($docs);
        return view('site.index', compact('veiculos'));
    }

}
