<?php

namespace App\Services;

use App\Models\Servico;
use App\Models\Profissional;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SetupNovoUsuario
{

public static function criarDadosIniciais($empresaId)
{
    try {
        $usuario = User::where('empresa_id', $empresaId)->first();

        if (!$usuario) {
            Log::error("Não foi possível encontrar o usuário administrador para a empresa {$empresaId}");
            return;
        }

        // 1. Definição do Horário Padrão
        $horarioPadrao = [
            "segunda" => ["fim" => "18:00", "inicio" => "08:00", "trabalha" => "1"],
            "terça"   => ["fim" => "18:00", "inicio" => "08:00", "trabalha" => "1"],
            "quarta"  => ["fim" => "18:00", "inicio" => "08:00", "trabalha" => "1"],
            "quinta"  => ["fim" => "18:00", "inicio" => "08:00", "trabalha" => "1"],
            "sexta"   => ["fim" => "18:00", "inicio" => "08:00", "trabalha" => "1"]
        ];

        // 2. Criação dos Serviços Padrão com referências às imagens
        $servicosPadrao = [
            ['nome' => 'Corte', 'preco' => 80.00, 'duracao' => 60, 'descricao' => 'Corte personalizado.', 'image' => 'haircut.png'],
            ['nome' => 'Maquiagem', 'preco' => 50.00, 'duracao' => 40, 'descricao' => 'Maquiagem profissional.', 'image' => 'makeup.png'],
            ['nome' => 'Manicure', 'preco' => 30.00, 'duracao' => 45, 'descricao' => 'Cutilagem e esmaltação.', 'image' => 'manicure.png'],
            ['nome' => 'Pedicure', 'preco' => 35.00, 'duracao' => 45, 'descricao' => 'Tratamento completo para os pés.', 'image' => 'pedicure.png'],
            ['nome' => 'Massagem', 'preco' => 120.00, 'duracao' => 90, 'descricao' => 'Massagem relaxante corporal.', 'image' => 'massage.png'],
            ['nome' => 'Skin Care', 'preco' => 150.00, 'duracao' => 30, 'descricao' => 'Sua pele, sua melhor versão.', 'image' => 'skin-care.png'],
        ];

        $servicosParaProfissional = [];

        foreach ($servicosPadrao as $dados) {
            $caminhoFinalNoBanco = null;

            // Lógica para copiar a imagem padrão para o storage da nova empresa
            $pathOrigem = public_path("vitrine/img/{$dados['image']}");
            
            if (File::exists($pathOrigem)) {
                $novoNome = \Illuminate\Support\Str::random(40) . '.png';
                $diretorioDestino = "servicos/{$empresaId}";
                $caminhoRelativoDestino = "{$diretorioDestino}/{$novoNome}";

                // Garante que a pasta da empresa existe no storage/public
                Storage::disk('public')->makeDirectory($diretorioDestino);
                
                // Copia o arquivo: public/vitrine/img -> storage/app/public/servicos/{id}/...
                File::copy($pathOrigem, storage_path("app/public/{$caminhoRelativoDestino}"));
                
                $caminhoFinalNoBanco = $caminhoRelativoDestino;
            }

            $servico = Servico::create([
                'nome'       => $dados['nome'],
                'preco'      => $dados['preco'],
                'duracao'    => $dados['duracao'],
                'descricao'  => $dados['descricao'],
                'image'       => $caminhoFinalNoBanco, // Nome do campo conforme sua controller
                'empresa_id' => $empresaId,
            ]);

            $servicosParaProfissional[] = [
                'id' => $servico->id,
                'nome' => $servico->nome,
                'comissao' => 100
            ];
        }

        // 3. Cadastra o Usuário como Profissional
        Profissional::create([
            'empresa_id'    => $empresaId,
            'user_id'       => $usuario->id,
            'nome'          => $usuario->name,
            'email'         => $usuario->email,
            'telefone'      => $usuario->telefone,
            'especialidade' => 'Cabelereiro (a)',
            'status'        => 1,
            'password'      => $usuario->password,
            'servicos'      => $servicosParaProfissional,
            'horarios'      => $horarioPadrao,
        ]);

    } catch (\Exception $e) {
        Log::error("Erro no SetupNovoUsuario para empresa {$empresaId}: " . $e->getMessage());
        throw $e; 
    }
}
}