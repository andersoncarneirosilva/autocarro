<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class PdfController extends Controller
{
    // Função principal para processar o PDF
    public function processPdf($pdfPath)
    {
        // Diretório de saída para as imagens extraídas
        $outputDir = storage_path('app/public/extracted_images');

        // Garante que o diretório de saída existe
        if (! file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        // Comando para extrair as imagens do PDF
        $command = "pdftoppm -jpeg $pdfPath $outputDir/page";
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            \Log::error("Erro ao executar o comando: $command");

            return response()->json(['error' => 'Falha ao extrair imagens do PDF'], 500);
        }

        // Lista as imagens geradas
        $images = glob("$outputDir/*.jpg");

        if (empty($images)) {
            \Log::error("Nenhuma imagem foi extraída do PDF: $pdfPath");

            return response()->json(['error' => 'Nenhuma imagem foi extraída do PDF'], 500);
        }

        // Aplica OCR em cada imagem
        $fullText = '';
        foreach ($images as $imagePath) {
            $text = $this->ocrImage($imagePath);
            \Log::info("Texto extraído da imagem {$imagePath}: ".$text);
            $fullText .= $text."\n";
        }

        // Retorna o texto extraído
        return response()->json(['text' => $fullText]);
    }

    // Função para aplicar OCR em uma imagem
    public function ocrImage($imagePath)
    {
        // Aplica o OCR na imagem
        $text = (new TesseractOCR($imagePath))
            ->executable('/usr/bin/tesseract') // Certifique-se de usar o caminho correto
            ->run();

        return $text;
    }

    // Função para fazer upload e processar o PDF
    public function uploadPdf(Request $request)
    {
        // Validação para garantir que o arquivo seja um PDF
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // 10MB máximo
        ]);

        // Salva o arquivo PDF no diretório público
        $fileName = 'documento.pdf';
        $pdfPath = $request->file('pdf')->storeAs('public/pdfs', $fileName);
        $pdfPath = storage_path("app/{$pdfPath}");

        // Processa o PDF e extrai o texto
        return $this->processPdf($pdfPath);
    }

    // Função para exibir o texto extraído na view
    public function showExtractedText(Request $request)
    {
        $pdfPath = $request->file('pdf')->storeAs('public/pdfs', 'documento.pdf');
        $pdfPath = storage_path("app/{$pdfPath}");

        // Processar o PDF e extrair o texto
        $fullText = $this->processPdf($pdfPath);

        // Exibe a página com o texto extraído
        return view('arquivos.resultado', ['text' => $fullText]);
    }
}
