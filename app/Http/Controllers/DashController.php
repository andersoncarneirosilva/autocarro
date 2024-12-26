<?php

namespace App\Http\Controllers;

use App\Models\DashModel;
use App\Models\Procuracao;
use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;

class DashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function index(Request $request){

        //$user = Auth::guard('tenant')->user(); // Use o guard 'tenant'
        //dd($user); 
        $search = $request->search;
        $emprestimos = Procuracao::orderBy('created_at', 'desc')->take(4)->get();
        //$users = $this->model->getUsersDash();
        $countDocs = $this->model->getCountDocs();
        $countProcs = $this->model->getCountProcs();
        $countCnh = 12;
        //dd($countAd);
        
        //dd($users);
        return view('dashboard.index', compact(['countDocs', 'countProcs', 'countCnh', 'emprestimos']));
    }
}