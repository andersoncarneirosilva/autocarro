<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DashModel;
use App\Models\Event;
use App\Models\User;
use App\Models\Anuncio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendNotificationStorageJob;

class DashController extends Controller
{
    protected $model;

    public function __construct(DashModel $info)
    {
        $this->model = $info;
    }

    public function index()
{

    return view('dashboard.index');
}
}
