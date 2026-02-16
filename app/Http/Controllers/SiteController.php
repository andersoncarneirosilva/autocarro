<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

}