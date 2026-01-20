<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Outorgado;
use App\Models\ModeloProcuracoes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use FPDF;
use Smalot\PdfParser\Parser;
class DocumentoController extends Controller
{
    public function gerarProcuracao(Request $request, $anuncio_id)
    {
        
        $userId = Auth::id();
        $anuncio = Anuncio::findOrFail($anuncio_id);
        $cliente = Cliente::findOrFail($request->cliente_id);
        $configProc = ModeloProcuracoes::where('user_id', $userId)->first();

        // Verificação de Outorgados
        if (!$configProc || empty($configProc->outorgados)) {
            return back()->with('error_title', 'Configuração Pendente')
                        ->with('error', 'Por favor, cadastre ao menos um Outorgado nas configurações.');
        }
                
        // Configurações de Data
        $dataAtual = Carbon::now();
        $dataPorExtenso = $dataAtual->translatedFormat('d \d\e F \d\e Y');

        // Inicializar FPDF (Mantendo sua lógica de construção do PDF)
        $pdf = new Fpdf();
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        // Título
        $pdf->Cell(0, 10, utf8_decode('PROCURAÇÃO'), 0, 1, 'C');
        $pdf->Ln(8);

        // OUTORGANTE (Dados do Cliente selecionado no Modal)
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 5, 'OUTORGANTE: ' . strtoupper(utf8_decode($cliente->nome)), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 5, "CPF/CNPJ: " . $cliente->cpf_cnpj, 0, 1, 'L');
        $pdf->Cell(0, 5, utf8_decode("ENDEREÇO: " . strtoupper($cliente->endereco . ', ' . $cliente->cidade)), 0, 1, 'L');
        
        $pdf->Ln(5);
        $pdf->Cell(0, 0, '___________________________________________________________________________', 0, 1, 'L');
        $pdf->Ln(8);

        // OUTORGADOS (Lógica original de buscar do JSON)
        $outorgadosIds = json_decode($configProc->outorgados, true);
        $outorgados = Outorgado::whereIn('id', $outorgadosIds)->get();

        foreach ($outorgados as $outorgado) {
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(0, 5, utf8_decode("OUTORGADO: {$outorgado->nome_outorgado}"), 0, 1, 'L');
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(0, 5, "CPF: {$outorgado->cpf_outorgado}", 0, 1, 'L');
            $pdf->Cell(0, 5, utf8_decode("ENDEREÇO: {$outorgado->end_outorgado}"), 0, 1, 'L');
            $pdf->Ln(4);
        }

        $pdf->Ln(4);
        $pdf->Cell(0, 0, '___________________________________________________________________________', 0, 1, 'L');
        $pdf->Ln(8);

        // TEXTO INICIAL (Poderes)
        $pdf->SetFont('Arial', '', 10);
        $textoLimpo = str_replace("\n", ' ', $configProc->texto_inicial);
        $pdf->MultiCell(0, 5, utf8_decode($textoLimpo), 0, 'J');

        // DADOS DO VEÍCULO (Vindo do objeto $anuncio do banco)
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(100, 6, 'MARCA/MODELO: ' . strtoupper(utf8_decode($anuncio->marca . '/' . $anuncio->modelo)), 0, 0, 'L');
        $pdf->Cell(0, 6, 'PLACA: ' . strtoupper($anuncio->placa), 0, 1, 'L');
        $pdf->Cell(100, 6, 'CHASSI: ' . strtoupper($anuncio->chassi), 0, 0, 'L');
        $pdf->Cell(0, 6, 'COR: ' . strtoupper(utf8_decode($anuncio->cor)), 0, 1, 'L');
        $pdf->Cell(100, 6, 'ANO: ' . $anuncio->ano, 0, 0, 'L');
        $pdf->Cell(0, 6, 'RENAVAM: ' . $anuncio->renavam, 0, 1, 'L');

        // TEXTO FINAL
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 10);
        $textoFinalLimpo = str_replace("\n", ' ', $configProc->texto_final);
        $pdf->MultiCell(0, 5, utf8_decode($textoFinalLimpo), 0, 'J');

        // DATA E ASSINATURA
        $pdf->Ln(10);
        $pdf->Cell(0, 10, utf8_decode("$configProc->cidade, $dataPorExtenso"), 0, 1, 'R');
        $pdf->Ln(15);
        $pdf->Cell(0, 0, '_________________________________________________', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, strtoupper(utf8_decode($cliente->nome)), 0, 1, 'C');

        // --- NOVO BLOCO DE SALVAMENTO PADRONIZADO ---
    
        // 1. Define o nome do arquivo e o caminho da pasta do anúncio
        $nomeArquivo = 'PROCURACAO_' . strtoupper($anuncio->placa) . '.pdf';
        $pastaRelativa = "documentos/usuario_{$userId}/anuncios/anuncio_{$anuncio->id}/";
        $pastaDestino = storage_path("app/public/{$pastaRelativa}");

        // 2. Garante que a pasta do anúncio existe
        if (!file_exists($pastaDestino)) {
            mkdir($pastaDestino, 0775, true);
        }

        $caminhoCompleto = $pastaDestino . $nomeArquivo;

        // 3. Salva o PDF no disco
        $pdf->Output('F', $caminhoCompleto);
        
        // 4. ATUALIZAR OU CRIAR REGISTRO NA TABELA DOCUMENTOS
        // Salvamos o caminho relativo para facilitar o uso da Facade Storage
        $documento = Documento::updateOrCreate(
            ['anuncio_id' => $anuncio->id],
            [
                'user_id' => $userId,
                'cliente_id' => $cliente->id,
                'arquivo_proc' => $pastaRelativa . $nomeArquivo,
                'size_proc' => filesize($caminhoCompleto),
                'size_proc_pdf' => 'A4'
            ]
        );
        
        // Verificação de ATPV-E (Se houver)
        if ($request->tipo_documento == 'atpve') {
            $this->gerarPdfAtpve($anuncio, $cliente, $userId, $request->valor_venda);
        }

        return back()->with('success', 'Procuração gerada e salva na pasta do anúncio!');
    }


    private function gerarPdfAtpve($anuncio, $cliente, $userId, $valorVenda)
{
    //dd($anuncio);
    $configProc = ModeloProcuracoes::where('user_id', $userId)->first();
    $outorgados = Outorgado::first();

    $dataAtual = Carbon::now();

        $dataDia = $dataAtual->translatedFormat('d');
        $dataMes = $dataAtual->translatedFormat('m');
        $dataAno = $dataAtual->translatedFormat('Y');
        
    $dataAtual = Carbon::now();
    $pdf = new FPDF;
        $pdf->SetMargins(30, 30, 30);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);

        $titulo = utf8_decode('POP 2');
        $pdf->Cell(0, 10, $titulo, 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, 'ANEXO 2 - REQUERIMENTO DE PREENCHIMENTO DA ATPV-e', 0, 1, 'C');
        $pdf->Ln(10);

        // Corpo do documento
        $pdf->SetFont('Arial', '', 10);
        // $pdf->MultiCell(0, 8, "Eu, ");

        // Definir posição para o nome e sublinhar apenas a informação dinâmica
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Posição para o nome e sublinhado
        $pdf->Text($x, $y, 'Eu, ');
        $x += $pdf->GetStringWidth('Eu, '); // Ajusta o X para o nome

        // Reduz a distância entre "Eu," e o nome do outorgado
        $x += 0; // Ajuste fino para aproximar o nome de "Eu,"
        $nome_outorgado = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $outorgados->nome_outorgado);
        // Sublinha apenas o nome do outorgado
        $this->desenharSublinhado($pdf, $x, 60, $nome_outorgado, 140); // Chama o método dentro do controlador
        $x += 140; // Ajuste após o nome sublinhado

        // Continua o texto após o nome
        $pdf->Text($x, $y, ', ');
        $pdf->Ln(10);

        // Agora começa uma nova linha para o "CPF/CNPJ"
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'CPF/CNPJ:');
        $x += $pdf->GetStringWidth('CPF/CNPJ:'); // Ajusta o X para o CPF/CNPJ

        // Sublinha apenas o CPF/CNPJ
        $this->desenharSublinhado($pdf, $x, 69, $outorgados->cpf_outorgado, 56); // Chama o método dentro do controlador para o CPF/CNPJ
        $x += 56; // Ajuste após o CPF/CNPJ sublinhado

        // Continua o texto após o CPF/CNPJ
        $pdf->Text($x, $y, ', requeiro ao DETRAN/RS, o preenchimento da');
        $pdf->Ln(10); // Faz a quebra de linha para a próxima parte do texto

        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'ATPV-e, relativo ao veículo Placa:'));
        $x += $pdf->GetStringWidth('ATPV-e, relativo ao veículo Placa:');

        // Sublinha a "Placa"
        $this->desenharSublinhado($pdf, 84, 78, $anuncio->placa, 20); // Sublinha a "Placa"
        $x += 20; // Ajuste após a "Placa" sublinhada

        // Continua o texto após a "Placa"
        $pdf->Text($x, $y, '. Chassi:');
        $x += $pdf->GetStringWidth('. Chassi:'); // Ajuste para "Chassi"

        // Sublinha o "Chassi"
        $this->desenharSublinhado($pdf, $x, 78, $anuncio->chassi, 57); // Sublinha o "Chassi"
        $x += 57; // Ajuste após o "Chassi" sublinhado

        $pdf->Ln(10); // Linha em branco após o texto

        // Linha com "Renavam {$renavam} Marca/Modelo {$marca}"
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'Renavam:');
        $x += $pdf->GetStringWidth('Renavam:'); // Ajuste para "Renavam"

        // Sublinha o "Renavam"
        $this->desenharSublinhado($pdf, $x, 87, $anuncio->renavam, 54); // Sublinha o "Renavam"
        $x += 54; // Ajuste após o "Renavam" sublinhado

        // Continua o texto após "Renavam"
        $pdf->Text($x, $y, ' Marca/Modelo ');
        $x += $pdf->GetStringWidth(' Marca/Modelo '); // Ajuste para "Marca/Modelo"

        // Sublinha o "Marca/Modelo"
        $this->desenharSublinhado($pdf, $x, 87, $anuncio->marca, 53); // Sublinha o "Marca/Modelo"
        $x += 53; // Ajuste após o "Marca/Modelo" sublinhado

        $pdf->Ln(10); // Linha em branco após o texto

        // Agora vai para a nova linha para "PROPRIETÁRIO VENDEDOR:"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'PROPRIETÁRIO VENDEDOR:'));
        $x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', 'PROPRIETÁRIO VENDEDOR:'));  // Ajusta o X para "PROPRIETÁRIO VENDEDOR:"
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(7);

        // Posição do texto "e-mail: despachanteluis@hotmail.com"
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'e-mail: ');

        // Calcula a largura do texto do email
        $emailText = 'e-mail: ';
        $x += $pdf->GetStringWidth($emailText); // Atualiza a posição X após o texto

        // Sublinha o email
        $this->desenharSublinhado($pdf, 42, 103, $outorgados->cpf_outorgado, 80); // Sublinha apenas o email
        $x += 80; // Ajuste após o "Marca/Modelo" sublinhado

        $pdf->Ln(20); // Linha em branco após o texto

        // Agora vai para a nova linha para "IDENTIFICAÇÃO DO ADQUIRENTE"
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'IDENTIFICAÇÃO DO ADQUIRENTE'));
        $x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', 'IDENTIFICAÇÃO DO ADQUIRENTE'));  // Ajusta o X para "IDENTIFICAÇÃO DO ADQUIRENTE"
        $pdf->SetFont('Arial', '', 10);
        // Linha em branco após o título
        $pdf->Ln(8);

        $pdf->Text($x = 30, $y = $pdf->GetY(), 'CPF/CNPJ:');
        $x += $pdf->GetStringWidth('CPF/CNPJ:'); // Ajuste para "CPF/CNPJ:"

        // Sublinha o CPF
        $this->desenharSublinhado($pdf, $x, 130, $cliente->cpf, 93); // Sublinha o CPF
        $x += 93; // Ajuste após o CPF sublinhado

        $pdf->Ln(10);

        $pdf->Text($x = 30, $y = $pdf->GetY(), 'Nome:');
        $x += $pdf->GetStringWidth('Nome:');

        $this->desenharSublinhado($pdf, 41, 139, iconv('UTF-8', 'ISO-8859-1', $cliente->nome), 100);
        $x += 100;

        $pdf->Ln(10);

        $pdf->Text($x = 30, $y = $pdf->GetY(), 'e-mail: ');
        $x += $pdf->GetStringWidth('e-mail:'); // Ajuste para "CPF/CNPJ:"

        // Sublinha o CPF
        $this->desenharSublinhado($pdf, 41, 148, $cliente->email, 100); // Sublinha o CPF
        $x += 100;

        $pdf->Ln(20); // Linha em branco após o CPF

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text($x = 30, $y = $pdf->GetY(), iconv('UTF-8', 'ISO-8859-1', 'ENDEREÇO DO ADQUIRENTE'));
        $x += $pdf->GetStringWidth(iconv('UTF-8', 'ISO-8859-1', 'ENDEREÇO DO ADQUIRENTE'));
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(10); // Linha em branco após o CPF
        $pdf->Text($x = 30, $y = $pdf->GetY(), 'CEP:');
        $x += $pdf->GetStringWidth('CEP:'); // Ajuste para "Renavam"

        // Sublinha o "Renavam"
        $this->desenharSublinhado($pdf, $x, 177, $cliente->cep, 40); // Sublinha o "Renavam"
        $x += 40;

        $pdf->Text($x, $y, ' UF:');
        $x += $pdf->GetStringWidth(' UF:');

        $this->desenharSublinhado($pdf, $x, 177, $cliente->estado, 40);
        $x += 40;

        $pdf->Text($x, $y, iconv('UTF-8', 'ISO-8859-1', ' MUNICÍPIO:'));
        $x += $pdf->GetStringWidth(' MUNICÍPIO:');
        $municipio = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $cliente->cidade);
        $this->desenharSublinhado($pdf, 146, 177, $municipio, 40);
        $x += 40;

        $pdf->Ln(10);

        // Posição inicial do texto
        $x = 30;
        $y = $pdf->GetY();
        $pdf->Text($x, $y, 'Logradouro: ');

        // Ajusta posição para o endereço e sublinha
        $x += $pdf->GetStringWidth('Logradouro: ');
        $endereco = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $cliente->endereco);
        $this->desenharSublinhado($pdf, $x, 186, $endereco, 80);

        $x += 80;

        // Texto "N."
        $pdf->Text(142, $y, ' N.');
        $x += $pdf->GetStringWidth(' N.');

        // Ajusta para o número e sublinha
        $this->desenharSublinhado($pdf, 146, 186, $cliente->numero, 40);
        $x += 100;

        $pdf->Ln(10); // Linha em branco após o texto

        // Posição inicial do texto
        $x = 30;
        $y = $pdf->GetY();
        $pdf->Text($x, $y, 'Complemento:');
        $x += $pdf->GetStringWidth('Complemento:');
        $complemento = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $cliente->complemento);
        $this->desenharSublinhado($pdf, $x, 195, $complemento, 40);
        $x += 40;

        // Texto "N."
        $pdf->Text($x, $y, ' Bairro:');
        $x += $pdf->GetStringWidth(' Bairro:');
        $bairro = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $cliente->bairro);
        // Ajusta para o número e sublinha
        $this->desenharSublinhado($pdf, $x, 195, $bairro, 40);
        $x += 100;

        $pdf->Ln(10); // Linha em branco após o texto

        $pdf->SetFont('Arial', 'B', 10);

        // Posição inicial do texto
        $x = 30;
        $y = $pdf->GetY();
        $pdf->Text($x, $y, 'Valor:');
        // Ajusta posição para o endereço e sublinha
        $x += $pdf->GetStringWidth('Valor:');
        $this->desenharSublinhado($pdf, $x, 204, 'R$ '.$valorVenda, 40);
        $x += 40;

        $pdf->Ln(10);

        $pdf->Cell(0, 8, iconv('UTF-8', 'ISO-8859-1', 'Declaro que li, estou de acordo e sou responsável pelas informações acima.'), 0, 1, 'C');

        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        // Define a posição inicial
        $x = 30;
        $y = $pdf->GetY();

        // Exibe o texto fixo "Data"
        $pdf->SetFont('Arial', '', 10);
        $pdf->Text($x, $y, 'Data: ');

        // Ajusta a posição para o primeiro campo (dia)
        $x += $pdf->GetStringWidth('Data: '); // Move o cursor para a direita
        $this->desenharSublinhado($pdf, $x, 231, $dataDia, 8); // Campo do dia sublinhado
        $x += 8; // Ajusta após o sublinhado do dia

        // Adiciona o separador "/"
        $pdf->Text($x, $y, ' / ');
        $x += $pdf->GetStringWidth(' / '); // Move o cursor após o "/"

        // Sublinha o campo do mês
        $this->desenharSublinhado($pdf, $x, 231, $dataMes, 8); // Campo do mês sublinhado
        $x += 8; // Ajusta após o sublinhado do mês

        // Adiciona o separador "/"
        $pdf->Text($x, $y, ' / ');
        $x += $pdf->GetStringWidth(' / '); // Move o cursor após o "/"

        // Sublinha o campo do ano (20____)
        $this->desenharSublinhado($pdf, $x, 231, $dataAno, 10); // Campo do ano sublinhado
        $x += 15; // Ajusta após o sublinhado do ano

        $pdf->Ln(20); // Linha em branco após o texto

        $pdf->Cell(0, 8, '__________________________________________', 0, 1, 'C');
        $pdf->Cell(0, 8, 'Assinatura do vendedor/representante legal', 0, 1, 'C');

    // Salvamento
    $nomeArquivo = 'atpve_'.$anuncio->placa.'_'.time().'.pdf';
    $caminhoRelativo = "documentos/usuario_{$userId}/atpves/{$nomeArquivo}";
    $caminhoAbsoluto = storage_path("app/public/".$caminhoRelativo);

    if (!Storage::disk('public')->exists("documentos/usuario_{$userId}/atpves")) {
        Storage::disk('public')->makeDirectory("documentos/usuario_{$userId}/atpves");
    }

    $pdfContent = $pdf->Output('S');
    Storage::disk('public')->put($caminhoRelativo, $pdfContent);

    // Atualiza a tabela documentos
    Documento::updateOrCreate(
        ['anuncio_id' => $anuncio->id],
        [
            'user_id' => $userId,
            'cliente_id' => $cliente->id,
            'arquivo_atpve' => $caminhoRelativo,
            'size_atpve' => strlen($pdfContent),
            'size_atpve_pdf' => 'A4'
        ]
    );
}

public function desenharSublinhado($pdf, $x, $y, $texto, $largura)
    {
        $pdf->SetXY($x, $y);
        $pdf->Cell($largura, 0, $texto, 0, 0, 'L');
        $pdf->Line($x, $y + 2, $x + $largura, $y + 2); // Linha sublinhada
    }

}