<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PixController extends Controller
{
    protected $model;


    public function index()
    {
        return view('site.pixdesign.index');
    }

}
