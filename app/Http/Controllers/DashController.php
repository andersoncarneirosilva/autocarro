<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DashModel;
use App\Models\Event;
use App\Models\User;
use App\Models\Veiculo;
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

    public function index(Request $request)
    {
        // dd(auth()->user());
        // abort(404);
        // dd($event);
        $search = $request->search;

        $userId = Auth::id();
        $user = User::find($userId);

        // Passar as informações para a view
        return view('dashboard.index');
    }
}
