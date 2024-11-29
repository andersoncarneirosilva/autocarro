<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Adiantamento;
class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Adiantamento::create([
            'colaborador' => 'Fernando',
            'email' => 'andersonqipoa@gmail.com',
            'arquivo' => 'contracheques/pagamento-Anderson.pdf',
            'mes' => 'Janeiro',
            'status' => 'PENDENTE',
            'class_status' => 'badge badge-outline-warning',
            //'foto' => 'users/s52QXrfmYtbIlJyLBWBqg3oqWxEu0SeYi7QewnQI.jpg',
            'foto' => 'users/weXdPodpa940j2I6Mhbtavn9TW9Y7jTyHeMdShYe.png',
        ]);
    }
}
