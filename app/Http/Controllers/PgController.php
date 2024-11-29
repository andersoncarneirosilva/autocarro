<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PgController extends Controller
{   

    protected $model;

    public function __construct(Pagamento $pag)
    {
        $this->model = $pag;
    }

    public function index(Request $request){
        
        $search = $request->search;

        $pags = $this->model->getPagamentos(colaborador: $request->colaborador, mes: $request->mes, status: $request->status ?? '');
        $users = User::all();
        //dd($pags);
        $title = 'Excluir!';
        $text = "Deseja excluir esse pagamento?";
        confirmDelete($title, $text);

        return view('pagamento.index', compact('pags','users'));
    }

    public function create(){
        $users = User::all();
        return view('pagamento.create', compact('users','users'));
    }
    
    public function store(Request $request){
        $data = $request->all();

        if($request->colaborador == "Todos"){
            // Obter o arquivo PDF
            $arquivo = $request->file('arquivo')->getRealPath();
            // Realizar o parsing do arquivo PDF
            $parser = new Parser();
            $pdf = $parser->parseFile($arquivo);
            //dd($pdf);
            $extension = $request->arquivo->getClientOriginalExtension();
            // Array para armazenar os usuários encontrados
            $usuarios = [];
            // Percorrer as páginas do PDF
            foreach ($pdf->getPages() as $numeroPagina => $pagina) {
                // Obter o texto da página
                $textoPagina = $pagina->getText();
                
                // Extrair o nome do usuário do texto da página
                $nomeUsuario = $this->model->extrairNomeUsuario($textoPagina);
                $emailUsuario = $this->model->extrairEmailUsuario($nomeUsuario);
                $fotoUsuario = $this->model->extrairFotoUsuario($nomeUsuario);
                $dataAtual = Carbon::now();
                $numeroMes = $dataAtual->format('m');
                $mes = $request->mes;
                $diretorioDestino = $nomeUsuario;

                // Verifica se o diretório de destino existe, senão cria
                if (!file_exists($diretorioDestino)) {
                    mkdir($diretorioDestino, 0777, true);
                }
                //dd($numeroMes);
                if (!empty($nomeUsuario)) {
                    $usuarios[] = $nomeUsuario;
                    // Dividir a página em um novo arquivo PDF
                    $novoPDF = new Fpdi();
                    $novoPDF->AddPage();
                    $novoPDF->setSourceFile($arquivo);
                    $novoPDF->useTemplate($novoPDF->importPage($numeroPagina + 1));

                    // Gerar um nome único para o novo arquivo
                    $nomeArquivo = 'arquivo_' . $dataAtual . '.pdf';

                    // Criar o diretório com o nome do usuário dentro da pasta 'pdf_dividido'
                    $pastaUsuario = "usuarios/{$nomeUsuario}/Salario/{$mes}";

                    // Verificar se o diretório de destino existe, senão criar
                    if (!File::exists(storage_path("app/public/{$pastaUsuario}"))) {
                        File::makeDirectory(storage_path("app/public/{$pastaUsuario}"), 0777, true);
                    }

                    // Caminho da pasta de destino relativo à pasta "public"
                    $caminhoDestinoRelativo = "usuarios/{$nomeUsuario}/Salario/{$mes}";

                    // Caminho completo do arquivo
                    $caminhoArquivo = storage_path("app/public/{$caminhoDestinoRelativo}/{$nomeArquivo}");
                    //dd($caminhoArquivo);
                    $novoPDF->Output($caminhoArquivo, 'F');


                    $pagamento = new Pagamento();
                    $pagamento->colaborador = $nomeUsuario;
                    $pagamento->arquivo = $caminhoArquivo;
                    $pagamento->foto = $fotoUsuario;
                    $pagamento->email = $emailUsuario;
                    $pagamento->numeromes = $numeroMes;
                    $pagamento->mes = $mes;
                    $pagamento->status = "PENDENTE";
                    $pagamento->class_status = "badge badge-outline-warning";
                    //dd($adiantamento->mes);
                    $pagamento->save();

                }
            }

            if($pagamento->save()){
                alert()->success('Contracheques cadastrados com sucesso!');
                return redirect()->route('pagamento.index');
            }
        }else{
            $caminhoArquivoPDF = $request->file('arquivo')->path();

            $dataAtual = Carbon::now();
            
            $extension = $request->arquivo->getClientOriginalExtension();

            if($extension == ""){
                alert()->error('Carregue um arquivo em PDF!');
                return redirect()->route('adiantamento.index');
            }
            if(!$request->colaborador){
                alert()->error('Selecione o colaborador!');
                return redirect()->route('adiantamento.index');
            }elseif(!$request->email){
                alert()->error('Preencha o campo e-mail');
                return redirect()->route('adiantamento.index');  
            }elseif(!$request->arquivo){
                alert()->error('Carregue um arquivo em PDF!');
                return redirect()->route('adiantamento.index');    
            }elseif($extension != "pdf"){
                alert()->error('Carregue um arquivo PDF!');
                return redirect()->route('adiantamento.index');    
            }else{
                $data['arquivo'] = $request->arquivo->storeAs("usuarios/$request->colaborador/Adiantamento/$request->mes/arquivo-$dataAtual" . ".{$extension}");
            }
            
            //Mail::to( config('mail.from.address'))->send(new SendEmail($data));

            if($this->model->create($data)){
                alert()->success('Contracheque cadastrado com sucesso!');
                return redirect()->route('adiantamento.index');
            }
            
        }
        
    }

    public function destroy($id){
        $pag = $this->model;
        
        $adiantamento = $pag->find($id);
        
        if (!$adiantamento) {
            alert()->error('Erro ao excluir o adiantamento!');
        } else {
                $caminhoArquivo = str_replace('/var/www/storage/app/public/', '', $adiantamento->arquivo);
                if (Storage::disk('public')->exists($caminhoArquivo)) {
                    Storage::disk('public')->delete($caminhoArquivo);
                    $adiantamento->delete();
                    alert()->success('Adiantamento excluído com sucesso!');
                } else {
                    alert()->error('Arquivo não encontrado!');
                }
        }

            return redirect()->route('pagamento.index');
    }
}
