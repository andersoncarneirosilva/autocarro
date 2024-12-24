<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // Modelo de exemplo, pode ser o modelo de qualquer entidade que irá associar o arquivo.
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrController extends Controller
{
    // Função para upload da imagem e extração de texto
    class OcrController extends Controller
{
    public function uploadAndExtractText(Request $request)
    {
        // Valida o arquivo de imagem enviado
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cria um usuário fictício ou outro modelo, para associar o arquivo
        $user = User::first(); // Aqui você pode pegar o usuário logado ou qualquer modelo

        // Armazena o arquivo de imagem com a Spatie Media Library
        $media = $user->addMedia($request->file('image'))
                      ->toMediaCollection('images'); // "images" é o nome da coleção

        // Caminho do arquivo armazenado
        $imagePath = $media->getPath();

        // Aplica o OCR na imagem e extrai o texto
        $text = $this->ocrImage($imagePath);

        // Retorna o texto extraído
        return response()->json(['text' => $text]);
    }

    // Função para aplicar o OCR usando o Tesseract
    public function ocrImage($imagePath)
    {
        // Inicializa o TesseractOCR e aplica OCR na imagem
        $text = (new TesseractOCR($imagePath))->run();

        return $text;
    }
}
}
