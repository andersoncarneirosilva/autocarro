<?php

namespace App\Util;

use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TenantConnector
{
    public static function connect(Tenant $tenant)
    {
        DB::purge('tenant');

        $config = Config::get('database.connections.main');
        $config['host'] = $tenant->host;
        $config['port'] = $tenant->port;
        $config['database'] = $tenant->database_name;
        $config['username'] = $tenant->username;
        $config['password'] = Crypt::decrypt($tenant->password);

        Config::set('database.connections.tenant', $config);
    }
}
