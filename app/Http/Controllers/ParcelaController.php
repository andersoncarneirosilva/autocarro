<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Parcela;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ParcelaController extends Controller
{   

    protected $model;
    public static $variavelGlobal;
    public function __construct(Parcela $parce)
    {
        $this->model = $parce;
    }

    public function index(Request $request){
        $title = 'Excluir!';
        $text = "Deseja excluir esse usuário?";
        confirmDelete($title, $text);
    }

    public function show($id){
        //CAIXA DE DIALOGO EXCLUIR
        $title = 'Excluir!';
        $text = "Deseja excluir essa parcela?";
        confirmDelete($title, $text);

        //EXIBIR PARCELAS REFERENTE AO EMPRESTIMO
        $data = DB::table('parcelas')->where('emprestimo_id', $id)->get();

        // $dataAtual = Carbon::now();

        // foreach ($data as $dat) {
        //     //RETORNA A DATA DE VENCIMENTO DA PARCELA
        //     $dataVencimento = Carbon::parse($dat->vencimento_at);
        //     //RETORNA SE A PARCELA ESTA VENCIDA -- TRUE/FALSE
        //     $parcelaVencida = $dataVencimento->isPast();
        //     $statusParcela = $dat->status;
            
        //     if ($parcelaVencida && $statusParcela == "PENDENTE") {

        //         $parcelas = Parcela::where('id', $dat->id)->first();

        //         if($parcelas){
        //         $parcelas->fill([
        //             'status' => 'ATRASADO',
        //             'class_status' => 'badge badge-danger-lighten',
        //             ]);
        //             $parcelas->save();
        //         }else{
        //             Log::info($parcelas);
        //         }
        //     }
        // }

        //RETORNAR TODAS AS PARCELAS REFERENTE AO EMPRESTIMO
        return view('parcelas.show', compact('data'));
    }

    public function update(Request $request, $id){
        
        $data = $request->all();
        $parcela = $this->model->find($id);

        if(!$parcela){
            return redirect()->route('emprestimos.index');
        }

        $parcela->update($data);
        
        alert()->success('Pagamento atualizado com sucesso!');

        return redirect()->route('parcelas.show', $parcela->emprestimo_id);
    }

    public function destroy($id){

        if(!$data = $this->model->find($id)){
            return redirect()->route('emprestimos.index');
        }

        $ultimoCad = DB::table('parcelas')->count();
        //dd($ultimoCad);

        /*if($ultimoCad == 0){
            DB::table('emprestimos')->count();
        }*/

        if($data->delete()){
            alert()->success('Parcela excluída com sucesso!');
        }
        return redirect()->route('emprestimos.index');
    }
    
}
