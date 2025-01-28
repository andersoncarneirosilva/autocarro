<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Veiculo extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'cpf',
        'endereco',
        'marca',
        'placa',
        'chassi',
        'cor',
        'ano',
        'renavam',
        'cidade',
        'crv',
        'placaAnterior',
        'categoria',
        'motor',
        'combustivel',
        'infos',
        'tipo',
        'arquivo_doc',
        'size_doc',
        'arquivo_proc',
        'size_proc',
        'arquivo_proc_assinado',
        'arquivo_atpve',
        'size_atpve',
        'arquivo_atpve_assinado',
        'size_proc_pdf',
        'size_atpve_pdf',
        'user_id',

    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSearch(?string $search = null, $userId)
{
    return $this->where('user_id', $userId) // Filtro pelo usuário logado
        ->when($search, function ($query) use ($search) {
            // Se houver pesquisa, filtra por renavam ou placa
            $query->where('placa', 'LIKE', "%{$search}%")
                  ->orWhere('renavam', 'LIKE', "%{$search}%");
        })
        ->orderBy('created_at', 'desc') // Ordena pelo mais recente
        ->paginate(20); // Retorna os resultados paginados
}


    public function getDocs(string|null $search = null){

        $docs = $this->where(function ($query) use ($search) {
            if($search){
                $query->where('placa', 'LIKE', "%{$search}%");
                $query->orWhere('nome', 'LIKE', "%{$search}%");
            }
        })->paginate(10);
        return $docs;
    }

    public function validaDoc($textoPagina){

        $linhas = explode("\n", $textoPagina);

        // Verifique se o índice 53 existe no array
        if (isset($linhas[3])) {
            // Se o índice existir, divida a linha
            $nome = explode("\t", $linhas[3]);
                    //dd($nome);
            $validador = implode(', ', $nome);
        } else {
            // Se o índice não existir, lance um erro ou retorne uma mensagem específica
            return "Erro: A linha esperada (53) não foi encontrada no texto.";
        }

        // Retorne a marca extraída ou a mensagem de erro
        return $validador;
    }

    public function extrairNome($textoPagina){
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

    public function extrairCpf($textoPagina){
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

    // public function extrairCidade($textoPagina) {
    //     // Divide o texto em linhas
    //     $linhas = explode("\n", $textoPagina);
    
    //     // Verifica se a linha 64 existe
    //     if (isset($linhas[64])) {
    //         // Remove possíveis espaços em branco ou tabulações na linha
    //         $linha = trim($linhas[64]);
    
    //         // Divide a linha em partes, usando espaço ou tabulação como delimitador
    //         $partes = preg_split('/\s+/', $linha);
    
    //         // Verifica se a cidade e o estado estão presentes
    //         if (isset($partes[0], $partes[1])) {
    //             // Concatena a cidade e o estado com uma barra
    //             $cidadeEstado = $partes[0] . '/' . $partes[1];
    
    //             // Debug para verificar o valor capturado
    //             //dd($cidadeEstado);
    
    //             return $cidadeEstado;
    //         }
    //     }
    
    //     // Caso a linha 64 não exista ou esteja incompleta, retorna vazio ou gera um erro
    //     //dd('Linha 64 ou dados insuficientes');
    //     return '';
    // }

    public function extrairCidade($textoPagina) {
        $linhas = explode("\n", $textoPagina);
        //dd($linhas);
    
        if (isset($linhas[64])) {
            $linha = trim($linhas[64]);
            //dd($linha);
    
            // Remove qualquer conteúdo após o estado (RS, SP, etc.), incluindo tabulação e data
            $linhaSemData = preg_replace('/\s[A-Z]{2}\s*\t.*$/', '', $linha);
            //dd($linhaSemData);
    
            // Regex para extrair cidade e estado
            if (preg_match('/^(.+)\s([A-Z]{2})$/', $linhaSemData, $matches)) {
                $cidade = trim($matches[1]); // Captura a cidade completa
                $estado = $matches[2];      // Captura o estado (2 letras)
    
                return $cidade . '/' . $estado;
            } else {
                // Adiciona /RS caso o estado não seja identificado
                return $linhaSemData . '/RS';
            }
        }
    
        return '';
    }

    public function extrairCrv($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $linha = explode("\t", $linhas[51]);
                //dd($colunas);
                $crv = implode(', ', $linha);
            //dd($crv);

        // Caso nenhum nome de usuário seja encontrado
        return $crv ;
    }

    public function extrairPlacaAnterior($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);

        // Divida a linha 55 em palavras usando o espaço como delimitador
        $linha = explode(" ", $linhas[55]);

        // Captura o primeiro item (antes do espaço)
        $placaAnterior = isset($linha[0]) ? $linha[0] : '';  // Garante que não cause erro caso não exista
        //dd($cor);
        return $placaAnterior;
    }

    public function extrairCategoria($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);

        // Divida a linha 55 em palavras usando o espaço como delimitador
        $linha = explode(" ", $linhas[57]);

        // Captura o primeiro item (antes do espaço)
        $categoria = isset($linha[0]) ? $linha[0] : '';  // Garante que não cause erro caso não exista
        //dd($cor);
        return $categoria;
    }

    public function extrairMotor($textoPagina) {
        // Divide o texto em linhas
        $linhas = explode("\n", $textoPagina);
    
        // Verifica se a linha 60 existe
        if (isset($linhas[60])) {
            // Remove espaços e tabulações no início e no fim da linha
            $linha = trim($linhas[60]);
    
            // Divide a linha em palavras, considerando qualquer espaço ou tabulação como delimitador
            $partes = preg_split('/\s+/', $linha);
    
            // Captura o primeiro conjunto
            $motor = isset($partes[0]) ? $partes[0] : ''; // Garante que não cause erro caso não exista
    
            // Debug para verificar o valor capturado (se necessário)
            // dd($motor);
    
            return $motor;
        }
    
        // Caso a linha 60 não exista, retorna vazio
        return '';
    }

    public function extrairCombustivel($textoPagina){
        $linhas = explode("\n", $textoPagina);

        // Divida a linha 55 em palavras usando o espaço como delimitador
        $linha = explode(" ", $linhas[56]);
//dd($linha);
        // Captura o primeiro item (antes do espaço)
        $combustivel = isset($linha[1]) ? $linha[1] : '';  // Garante que não cause erro caso não exista
        //dd($cor);
        return $combustivel;
    }
    
    public function extrairInfos($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $linha = explode("\t", $linhas[65]);
                //dd($colunas);
                $infos = implode(', ', $linha);
            //dd($outorgante);

        // Caso nenhum nome de usuário seja encontrado
        return $infos ;
    }

    public function extrairEspecie($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        
        $linhas = explode("\n", $textoPagina);
        //dd($linhas);
        $linha = explode("\t", $linhas[54]);
        //dd($colunas);
        $tipos = implode(', ', $linha);
        
        // Dividir a string por espaços para extrair o segundo nome
        $tiposArray = explode(' ', $tipos);
    
        // Verificar se existe pelo menos 2 palavras, e retornar o segundo nome
        if (count($tiposArray) > 1) {
            return $tiposArray[1]; // Retorna o segundo nome
        }
    
        // Caso não haja segundo nome, retorna a string original
        return $tipos;
    }
    
    
}
