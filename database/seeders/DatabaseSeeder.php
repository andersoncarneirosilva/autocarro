<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ordem;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(60)->create();

         $this->call([
            UserSeeder::class, // Substitua pelo nome real do seeder
            DocSeeder::class, // Adicione outros seeders conforme necessário
            ProcuracaoSeeder::class,
            ConfigProcSeeder::class,
        ]);
        
    }
}
