<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'nome' => 'MARILENE PRATES CARNEIRO DA SILVA',
            'email' => 'mari@gmail.com',
            'database' => 'central',
            'password' => bcrypt('123456789'),
        ]);
        
        
    }
}
