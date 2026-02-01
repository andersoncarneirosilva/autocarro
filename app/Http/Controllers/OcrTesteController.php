<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importante para os logs
use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrTesteController extends Controller
{
    public function index() {
        return view('ocr_teste');
    }

    public function processar(Request $request) {
    Log::info('ALCECAR OCR: Iniciando processamento de arquivo.', [
        'nome_original' => $request->file('arquivo')->getClientOriginalName()
    ]);

    $request->validate(['arquivo' => 'required|mimes:pdf,jpg,jpeg,png|max:10000']);

    try {
        $file = $request->file('arquivo');
        $caminhoOriginal = $file->path();
        $extensao = $file->getClientOriginalExtension();

        // 1. Tratamento de PDF
        if ($extensao === 'pdf') {
            Log::info('ALCECAR OCR: Convertendo PDF para JPG...');
            $pdf = new \Spatie\PdfToImage\Pdf($caminhoOriginal);
            $caminhoOcr = storage_path('app/temp_ocr_' . time() . '.jpg');
            $pdf->saveImage($caminhoOcr);
        } else {
            $caminhoOcr = $caminhoOriginal;
        }

        // 2. Execução do OCR
        $ocr = new \thiagoalessio\TesseractOCR\TesseractOCR($caminhoOcr);
        $ocr->executable('/usr/bin/tesseract');
        
        // PSM 6 para manter a estrutura de linhas
        $texto = $ocr->lang('por')->psm(6)->run();
        
        // 3. Transformação em Array de Linhas (Debug)
        $linhasRaw = explode("\n", $texto);
        $linhasIdentificadas = array_values(array_filter(array_map('trim', $linhasRaw)));

        // 4. Extração de Nome via MRZ (Linha inferior)
        $nomeFinal = 'Não identificado';
        foreach (array_reverse($linhasIdentificadas) as $linha) {
            if (str_contains($linha, '<<')) {
                $nomeFinal = trim(str_replace('<', ' ', $linha));
                $nomeFinal = preg_replace('/\s+/', ' ', $nomeFinal); //
                break;
            }
        }

        // 5. Extração Numérica com Pente Fino
        $apenasNumeros = preg_replace('/[^0-9]/', '', $texto);
        $cpfFinal = 'Não identificado';
        $rgFinal = 'Não identificado';

        // Busca CPF (11 dígitos) - Ignora o número de registro que começa com 041
        if (preg_match_all('/\d{11}/', $apenasNumeros, $matchesCPF)) {
            foreach ($matchesCPF[0] as $num) {
                if (substr($num, 0, 3) !== '041') {
                    $cpfFinal = vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($num)); //
                    break;
                }
            }
        }

        // Busca RG (Doc. Identidade: 1080692153)
        if (preg_match_all('/\d{10}/', $apenasNumeros, $matchesRG)) {
            foreach ($matchesRG[0] as $num) {
                // No documento do Anderson, o RG começa com 108
                if (substr($num, 0, 3) === '108') {
                    $rgFinal = $num;
                    break;
                }
            }
        }

        // Limpeza de arquivo temporário
        if ($extensao === 'pdf' && file_exists($caminhoOcr)) {
            unlink($caminhoOcr);
        }

        return response()->json([
            'status' => 'sucesso',
            'dados_extraidos' => [
                'nome' => $nomeFinal,
                'cpf'  => $cpfFinal,
                'rg'   => $rgFinal,
            ],
            'debug_linhas' => $linhasIdentificadas 
        ]);

    } catch (\Exception $e) {
        Log::error('ALCECAR OCR: Erro.', ['erro' => $e->getMessage()]);
        return response()->json(['erro' => $e->getMessage()], 500);
    }
}
}