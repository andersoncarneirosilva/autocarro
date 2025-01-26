<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OCRController extends Controller
{
    // Exibir a página inicial
    public function index()
    {
        return view('ocr.index');
    }

    // Processar o upload e fazer OCR
    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Obter o arquivo enviado
        $file = $request->file('file');

        // Fazer a requisição para a API OCR.Space
        $client = new Client();
        $response = $client->post('https://api.ocr.space/parse/image', [
            'headers' => [
                'apikey' => 'K81243224288957', // Substitua pela sua API Key
            ],
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => fopen($file->getPathname(), 'r'),
                ],
                [
                    'name'     => 'language',
                    'contents' => 'por', // Idioma (português neste caso)
                ],
            ],
        ]);

        // Obter e decodificar a resposta
        $result = json_decode($response->getBody(), true);

        // Verificar se houve sucesso
        if (!isset($result['ParsedResults'][0]['ParsedText'])) {
            return back()->withErrors(['msg' => 'Falha ao processar a imagem.']);
        }

        $extractedText = $result['ParsedResults'][0]['ParsedText'];

        return view('ocr.result', compact('extractedText'));
    }
}
