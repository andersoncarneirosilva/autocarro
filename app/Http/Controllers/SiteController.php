<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use Illuminate\Http\Request;
use Parsedown;

class SiteController extends Controller
{

    public function index(Request $request)
{
    

    return view('site.index');
}


    
}
