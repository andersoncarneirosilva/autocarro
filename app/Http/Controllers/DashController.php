<?php

namespace App\Http\Controllers;

use App\Models\DashModel;
use Illuminate\Http\Request;
use App\Models\Emprestimo;
class DashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function index(Request $request){

        

        $search = $request->search;
        $emprestimos = Emprestimo::take(5)->get();
        //$users = $this->model->getUsersDash();
        $countAd = $this->model->getCountAdDash();
        //dd($emprestimos);
        
        //dd($users);
        return view('dashboard.index', compact(['countAd','emprestimos']));
    }
}