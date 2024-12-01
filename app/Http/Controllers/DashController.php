<?php

namespace App\Http\Controllers;

use App\Models\DashModel;
use Illuminate\Http\Request;
use App\Models\Documento;
class DashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function index(Request $request){

        

        $search = $request->search;
        //$emprestimos = Documento::take(5)->get();
        //$users = $this->model->getUsersDash();
        $countDocs = $this->model->getCountDocs();
        $countProcs = $this->model->getCountProcs();
        //dd($countAd);
        
        //dd($users);
        return view('dashboard.index', compact(['countDocs', 'countProcs']));
    }
}