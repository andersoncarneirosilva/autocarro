<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Mail\SendEmail;
use Mail;
use App\Models\Adiantamento;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{   

    protected $model;

    public function __construct(Adiantamento $pag)
    {
        $this->model = $pag;
        Carbon::setLocale('pt_BR');
    }

    public function index(Request $request){
        
        $search = $request->search;
        $pags = $this->model->getPagamentos(colaborador: $request->colaborador, mes: $request->mes, status: $request->status ?? '');
        //dd($pags);
        $users = Employee::all();

        $title = 'Excluir!';
        $text = "Deseja excluir esse adiantamento?";
        confirmDelete($title, $text);

        return view('adiantamento.index', compact('pags','users'));
    }

    public function create(){
        $users = User::all();
        return view('adiantamento.create', compact('users','users'));
    }

    public function obterIDs(){
        $funcionarios = Employee::select('id')->get();
        $ids = $funcionarios->pluck('id');

        return response()->json($ids);
}

    
    public function store(Request $request){
        $data = $request->all();
        //dd($data);
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
            /* $texto = $pdf->getText();
            $linhas = explode("\n", $texto);
                //dd($linhas);
                $colunas = explode("\t", $linhas[34]);
            dd($colunas); */
            foreach ($pdf->getPages() as $numeroPagina => $pagina) {
                // Obter o texto da página
                
                $textoPagina = $pagina->getText();
                //dd($textoPagina);
                $nomeUsuario = $this->model->extrairNomeUsuario($textoPagina);
                //dd($nomeUsuario);
                $emailUsuario = $this->model->extrairEmailUsuario($nomeUsuario);
                $fotoUsuario = $this->model->extrairFotoUsuario($nomeUsuario);
                //dd($fotoUsuario);
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
                    $pastaUsuario = "usuarios/{$nomeUsuario}/Adiantamento/{$mes}";

                    // Verificar se o diretório de destino existe, senão criar
                    if (!File::exists(storage_path("app/public/{$pastaUsuario}"))) {
                        File::makeDirectory(storage_path("app/public/{$pastaUsuario}"), 0777, true);
                    }

                    // Caminho da pasta de destino relativo à pasta "public"
                    $caminhoDestinoRelativo = "usuarios/{$nomeUsuario}/Adiantamento/{$mes}";

                    // Caminho completo do arquivo
                    $caminhoArquivo = storage_path("app/public/{$caminhoDestinoRelativo}/{$nomeArquivo}");
                    //dd($caminhoArquivo);
                    $novoPDF->Output($caminhoArquivo, 'F');


                    $adiantamento = new Adiantamento();
                    $adiantamento->colaborador = $nomeUsuario;
                    $adiantamento->arquivo = $caminhoArquivo;
                    $adiantamento->foto = $fotoUsuario;
                    $adiantamento->email = $emailUsuario;
                    $adiantamento->numeromes = $numeroMes;
                    $adiantamento->mes = $mes;
                    $adiantamento->status = "PENDENTE";
                    $adiantamento->class_status = "badge badge-outline-warning";
                    //dd($adiantamento->mes);
                    $adiantamento->save();

                }
            }

            if($adiantamento->save()){
                alert()->success('Contracheques cadastrados com sucesso!');
                return redirect()->route('adiantamento.index');
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
            
            Mail::to( config('mail.from.address'))->send(new SendEmail($data));

            if($this->model->create($data)){
                alert()->success('Contracheque cadastrado com sucesso!');
                return redirect()->route('adiantamento.index');
            }
            
        }
        
    }
    /* Testes */
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

            return redirect()->route('adiantamento.index');
    }
}