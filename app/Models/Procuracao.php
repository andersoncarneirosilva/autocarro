<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Procuracao extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'endereco',
        'cpf',
        'marca',
        'placa',
        'chassi',
        'cor',
        'ano',
        'modelo',
        'renavam',
        'arquivo_doc',
        'arquivo_proc',
    ];

    public function validaDoc($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $nome = explode("\t", $linhas[3]);
                //dd($nome);
                $validador = implode(', ', $nome);
            //dd($outorgante);

        // Caso nenhum nome de usuário seja encontrado
        return $validador ;
    }
    
    //Pesquisar colaboradores
    public function getSearch(string|null $search = null){

        $procs = $this->where(function ($query) use ($search) {
            if($search){
                $query->where('placa', 'LIKE', "%{$search}%");
                $query->orWhere('nome', 'LIKE', "%{$search}%");
            }
        })->paginate(10);
        return $procs;
    }

    public function extrairNomeOutorgado($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $nome = explode("\t", $linhas[62]);
                //dd($colunas);
                $outorgante = implode(', ', $nome);
            //dd($outorgante);

        // Caso nenhum nome de usuário seja encontrado
        return $outorgante ;
    }

    public function extrairCpfOutorgado($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $numCpf = explode("\t", $linhas[63]);
                //dd($colunas);
                $cpf = implode(', ', $numCpf);
            //dd($outorgante);

        // Caso nenhum nome de usuário seja encontrado
        return $cpf ;
    }

    public function extrairMarca($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $word_marca = explode("\t", $linhas[53]);
                //dd($colunas);
                $marca = implode(', ', $word_marca);
            //dd($outorgante);

        // Caso nenhum nome de usuário seja encontrado
        return $marca ;
    }

    public function extrairChassi($textoPagina){
        // Supondo que o texto é separado em linhas e você está interessado na linha 55
        $linhas = explode("\n", $textoPagina);

        // Divida a linha 55 em palavras usando o espaço como delimitador
        $word_chassi = explode(" ", $linhas[55]);

        // Captura o segundo item da string após o espaço (assumindo que o chassi começa após o primeiro espaço)
        $chassi = isset($word_chassi[1]) ? $word_chassi[1] : '';  // Garante que não cause erro caso não exista

        return $chassi;
    }

    public function extrairAnoModelo($textoPagina){
        // Supondo que o texto é separado em linhas e você está interessado na linha 50
        $linhas = explode("\n", $textoPagina);

        // Divida a linha 50 em palavras usando o espaço como delimitador
        $word_anoModelo = explode(" ", $linhas[50]);

        // Garantir que existem pelo menos dois elementos para formar o ano
        if (isset($word_anoModelo[0]) && isset($word_anoModelo[1])) {
            // Formatar o resultado como "2010/2010"
            $anoModelo = $word_anoModelo[0] . '/' . $word_anoModelo[1];
            //dd($anoModelo);
        } else {
            $anoModelo = ''; // Caso não consiga extrair os dois anos, retorna uma string vazia
        }

        return $anoModelo;
    }

    public function extrairPlaca($textoPagina){
        // Supondo que o texto é separado em linhas e você está interessado na linha 55
        $linhas = explode("\n", $textoPagina);

        // Divida a linha 55 em palavras usando o espaço como delimitador
        $word_placa = explode(" ", $linhas[49]);

        // Captura o primeiro item (antes do espaço)
        $placa = isset($word_placa[0]) ? $word_placa[0] : '';  // Garante que não cause erro caso não exista
        //dd($placa);
        return $placa;
    }

    public function extrairCor($textoPagina){
        $linhas = explode("\n", $textoPagina);

        // Divida a linha 55 em palavras usando o espaço como delimitador
        $word_cor = explode(" ", $linhas[56]);

        // Captura o primeiro item (antes do espaço)
        $cor = isset($word_cor[0]) ? $word_cor[0] : '';  // Garante que não cause erro caso não exista
        //dd($cor);
        return $cor;
    }

    public function extrairRevanam($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $word_renavam = explode("\t", $linhas[48]);
                //dd($colunas);
                $renavam = implode(', ', $word_renavam);
            //dd($outorgante);

        // Caso nenhum nome de usuário seja encontrado
        return $renavam ;
    }
}