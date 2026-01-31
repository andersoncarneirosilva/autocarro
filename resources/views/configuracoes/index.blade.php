@extends('layouts.app')

@section('title', 'Designer de Procuração')

@section('content')

@include('components.toast')


<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Designer de Procuração</li>
                </ol>
            </div>
            <h3 class="page-title"><i class="mdi mdi-file-document-edit-outline me-2"></i>Modelo de Procuração</h3>
            @if(empty($modeloProc->id))
    <div class="alert alert-danger border-0 shadow-sm mb-3">
        <i class="mdi mdi-information-outline me-1"></i>
        <strong>Atenção:</strong> Você está visualizando um modelo padrão. 
        Por favor, revise o texto e clique em <strong>"Salvar Alterações"</strong> para ativar este modelo.
    </div>
@endif
        </div>
    </div>
</div>

<form method="POST" action="{{ route('configuracoes.procuracao.save') }}" id="outorgadosForm">
    @csrf
    {{-- Input hidden para o ID do modelo (importante para o save) --}}
    <input type="hidden" name="id" id="modelo_id" value="{{ $modeloProc->id ?? '' }}">

    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body p-0"> {{-- Removido padding para o fundo cinza do editor cobrir tudo --}}
                    <textarea name="conteudo" id="edit_conteudo">
                        @if(empty($modeloProc->conteudo))
<p style="text-align:center;"><strong>PROCURAÇÃO</strong></p><p><br><strong>OUTORGANTE: {NOME_CLIENTE}</strong><br>
    <strong>CPF: {CPF_CLIENTE}</strong><br><strong>ENDEREÇO: {ENDERECO_CLIENTE}</strong>
    <br>______________________________________________________________________________________</p>
    <p style="text-align:justify;"><strong>{INICIO_OUTORGADOS}</strong><br><strong>OUTORGADO: {NOME_OUTORGADO}</strong>
    <br><strong>CPF: {CPF_OUTORGADO}</strong><br><strong>ENDEREÇO: {ENDERECO_OUTORGADO}</strong><br><strong>{FIM_OUTORGADOS}</strong>
    <br>______________________________________________________________________________________<br>FINS E PODERES: O OUTORGANTE confere 
    ao OUTORGADO amplos e ilimitados poderes para o fim especial de vender a quem quiser, receber valores de venda, transferir para si
    próprio ou terceiros, em causa própria, locar ou de qualquer forma alienar ou onerar o veículo de sua propriedade com as seguintes 
    características:</p><figure class="table" style="width:100%;"><table class="ck-table-resized"><colgroup><col style="width:70.94%;">
    <col style="width:29.06%;"></colgroup><tbody><tr><td><strong>MARCA: {MARCA_MODELO}&nbsp;</strong></td><td><strong>PLACA: &nbsp;{PLACA}
    </strong></td></tr><tr><td><strong>CHASSI: &nbsp;{CHASSI}&nbsp;</strong></td><td><strong>COR: &nbsp;{COR}</strong></td></tr><tr><td>
    <strong>ANO/MODELO: {MARCA_MODELO}&nbsp;</strong></td><td><strong>RENAVAM: {RENAVAM}</strong></td></tr></tbody></table></figure>
    <p style="text-align:justify;">______________________________________________________________________________________<br>
    Assinar requerimentos, com poderes também para requerer, junto aos CRVAS/DETRAN-RS, os processos de 2ª vias de CRV/CRLV, Baixa Definitiva
    do veículo, Alterações de informações do veículo, Solicitar DCPPO e CRLV digital e ATPV-E, fazer declaração de residência, fazer alteração 
    de informações no veículo, fazer ocorrência policial de perda de documento do veículo, assinar termo de responsabilidade pela não 
    apresentação de placas e lacre, fazer troca de município, receber valores por indenização de Seguradoras, assinar contratos de inclusão 
    e instrumentos de liberação de Alienação e Reserva de Domínio para si próprio ou terceiros, endossar documentos, usar o veículo em apreço, 
    manejando o mesmo em qualquer parte do território nacional ou estrangeiro, ficando cível e criminalmente responsável por qualquer acidente 
    ou ocorrência, pagar taxas, multas e impostos, liberar e retirar o veículo de depósitos do DETRAN, CRD e DELEGACIAS DE POLÍCIA CIVIL, EPTC,
     PRF, POLÍCIA FEDERAL, BRIGADA MILITAR, POLÍCIA RODOVIÁRIA ESTADUAL, assinar termos de liberação, dar declarações e finalmente, usar e 
     gozar do veículo como coisa sua e sem interferência ou autorização de outros, podendo ainda requerer perante autoridade alfandegária 
     ou aduaneira de país estrangeiro licença ou permissão de turismo pelo tempo que julgar conveniente, podendo substabelecer a presente 
     no todo ou em parte. O outorgante pelo presente instrumento declara-se responsável pelo pagamento de multas e impostos do veículo acima 
     descrito e caracterizado, até a data da outorga do presente mandato. ESTA PROCURAÇÃO É OUTORGADA EM CARÁTER IRREVOGÁVEL E IRRETRATÁVEL, 
     SEM QUALQUER PRESTAÇÃO DE CONTAS AO PROPRIETÁRIO, HERDEIROS OU TERCEIROS, VISTO TER SIDO QUITADO O PREÇO DO VALOR DE VENDA DA TABELA FIPE 
     NESTA DATA AO PROPRIETÁRIO.</p><p style="text-align:right;"><br>{CIDADE},{DATA_EXTENSO}</p>
     <p style="text-align:center;">______________________________________________________________________</p><p style="text-align:center;">
    <strong>{NOME_CLIENTE}</strong></p><p>&nbsp;</p>
    @else
        {!! $modeloProc->conteudo !!}
    @endif
                    </textarea>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <span class="text-muted small"></span>
                    <button type="submit" id="btnSalvar" class="btn btn-primary px-4 shadow-sm">
                        <i class="mdi mdi-check-all me-1"></i> Salvar Alterações
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-body">
                    <h5 class="header-title mb-3">Configurações</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Outorgados Vinculados:</label>
                        {{-- Localize o @foreach ou a verificação do Select2 e use assim: --}}
@php
    $outorgadosSelecionados = [];
    if (isset($modeloProc->outorgados)) {
        $data = $modeloProc->outorgados;
        // Se já for array, usa ele. Se for string, decodifica.
        $outorgadosSelecionados = is_array($data) ? $data : json_decode($data, true) ?? [];
    }
@endphp

<select class="select2 form-control select2-multiple" 
        data-toggle="select2" 
        id="edit_outorgados" 
        multiple="multiple" 
        name="outorgados[]" required>
    @foreach ($outorgados as $out)
        <option value="{{ $out->id }}" 
            @if(in_array($out->id, $outorgadosSelecionados)) selected @endif>
            {{ $out->nome_outorgado }}
        </option>
    @endforeach
</select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cidade Padrão:</label>
                        <input class="form-control" name="cidade" value="{{ $modeloProc->cidade ?? '' }}" required placeholder="Ex: Esteio/RS"/>
                    </div>

                    <hr class="mb-2">
                    
                    <h5 class="header-title mb-2 text-primary">Tags Dinâmicas</h5>
                    <p class="text-muted small mb-3">Toque na tag para inserir no texto:</p>

                    
                    <div class="accordion custom-accordion" id="custom-accordion-one">
    
    <div class="card mb-0">
        <div class="card-header" id="headingFour">
            <h5 class="m-0">
                <a class="custom-accordion-title d-block text-info"
                    data-bs-toggle="collapse" href="#collapseFour"
                    aria-expanded="true" aria-controls="collapseFour">
                    DATAS E ASSINATURA <i class="mdi mdi-chevron-down accordion-arrow"></i>
                </a>
            </h5>
        </div>

        <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-bs-parent="#custom-accordion-one">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-1">
                    <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{DATA_EXTENSO}')">{DATA_EXTENSO}</code>
                    <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{CIDADE}')">{CIDADE}</code>
                    <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{DIA_ATUAL}')">{DIA_ATUAL}</code>
                    <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{MES_ATUAL}')">{MES_ATUAL}</code>
                    <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{ANO_ATUAL}')">{ANO_ATUAL}</code>
                    <code class="cursor-pointer p-1 border text-dark" onclick="insertSignatureLine()">[LINHA PARA ASSINATURA]</code>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header" id="headingFive">
            <h5 class="m-0">
                <a class="custom-accordion-title collapsed d-block"
                    data-bs-toggle="collapse" href="#collapseFive"
                    aria-expanded="false" aria-controls="collapseFive">
                    CLIENTE (COMPRADOR) <i class="mdi mdi-chevron-down accordion-arrow"></i>
                </a>
            </h5>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-bs-parent="#custom-accordion-one">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-1">
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_CLIENTE}')">{NOME_CLIENTE}</code>
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_CLIENTE}')">{CPF_CLIENTE}</code>
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{RG_CLIENTE}')">{RG_CLIENTE}</code>
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{ENDERECO_CLIENTE}')">{ENDERECO_CLIENTE}</code>
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{TELEFONE_CLIENTE}')">{TELEFONE_CLIENTE}</code>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header" id="headingSix">
            <h5 class="m-0">
                <a class="custom-accordion-title collapsed d-block text-danger"
                    data-bs-toggle="collapse" href="#collapseSix"
                    aria-expanded="false" aria-controls="collapseSix">
                    DADOS DO VENDEDOR <i class="mdi mdi-chevron-down accordion-arrow"></i>
                </a>
            </h5>
        </div>
        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-bs-parent="#custom-accordion-one">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-1">
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_OUTORGADO}')">{NOME_OUTORGADO}</code>
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_OUTORGADO}')">{CPF_OUTORGADO}</code>
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{RG_OUTORGADO}')">{RG_OUTORGADO}</code>
                    <code class="cursor-pointer p-1 border" onclick="copyTag('{EMAIL_OUTORGADO}')">{EMAIL_OUTORGADO}</code>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-0">
        <div class="card-header" id="headingSeven">
            <h5 class="m-0">
                <a class="custom-accordion-title collapsed d-block text-success"
                    data-bs-toggle="collapse" href="#collapseSeven"
                    aria-expanded="false" aria-controls="collapseSeven">
                    DADOS DO VEÍCULO <i class="mdi mdi-chevron-down accordion-arrow"></i>
                </a>
            </h5>
        </div>
        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-bs-parent="#custom-accordion-one">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-1">
                    <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{PLACA}')">{PLACA}</code>
                    <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{CHASSI}')">{CHASSI}</code>
                    <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{RENAVAM}')">{RENAVAM}</code>
                    <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{MARCA_MODELO}')">{MARCA_MODELO}</code>
                    <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{COR}')">{COR}</code>
                    <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{ANO_MODELO}')" title="Exemplo: 2020/2021">{ANO_MODELO}</code>
                </div>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
</form>



<script>
let editorProcuracao;

document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.ClassicEditor
        .create(document.querySelector('#edit_conteudo'), {
            placeholder: 'Comece a digitar o texto da sua procuração aqui...',
            removePlugins: ['AIAssistant','CKBox','CKFinder','EasyImage','RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges','RealTimeCollaborativeRevisionHistory','PresenceList','Comments','TrackChanges','TrackChangesData','RevisionHistory','Pagination','WProofreader','MathType','SlashCommand','Template','DocumentOutline','FormatPainter','TableOfContents','PasteFromOfficeEnhanced','CaseChange'],
            toolbar: {
                items: ['heading','|','bold','italic', 'horizontalLine' ,'underline','strikethrough','|','fontSize','fontColor','fontBackgroundColor','|','alignment','|','outdent','indent','|','bulletedList','numberedList','|','insertTable','link','blockQuote','|','undo','redo'],
                shouldNotGroupWhenFull: true
            },
            fontSize: { options: [ 10, 12, 14, 16, 18, 20, 22 ], supportAllValues: true },
            alignment: { options: [ 'left', 'center', 'right', 'justify' ] },
        })
        .then(editor => { 
            editorProcuracao = editor; 
        })
        .catch(error => { console.error(error); });

    $('#outorgadosForm').on('submit', function() {
        if (editorProcuracao) {
            document.querySelector('#edit_conteudo').value = editorProcuracao.getData();
        }

        // 2. Previne cliques duplos desabilitando o botão
            btnSalvar.disabled = true;

            // 3. Adiciona o feedback visual de loading
            btnSalvar.innerHTML = `
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Salvando...
            `;
    });

    $('.select2').select2();
});

function copyTag(tag) {
    if (editorProcuracao) {
        const viewFragment = editorProcuracao.data.processor.toView(tag);
        const modelFragment = editorProcuracao.data.toModel(viewFragment);
        editorProcuracao.model.insertContent(modelFragment);
        editorProcuracao.editing.view.focus();
    }
}
function insertSignatureLine() {
    if (editorProcuracao) {
        // Usamos uma estrutura que o editor interpreta como parágrafos centralizados
        // Adicionamos mais underlines para garantir uma linha de tamanho médio/grande
        const signatureHtml = `
            <div style="text-align: center; width: 100%;">
                <p style="text-align: center; margin-top: 60px; margin-bottom: 0px; font-family: Helvetica, Arial, sans-serif;">
                    ______________________________________________________________________
                </p>
                <p style="text-align: center; margin-top: 5px; font-family: Helvetica, Arial, sans-serif; font-size: 13px; text-transform: uppercase;">
                    {NOME_CLIENTE}
                </p>
            </div>
            <p style="text-align: left;">&nbsp;</p>`; 

        const viewFragment = editorProcuracao.data.processor.toView(signatureHtml);
        const modelFragment = editorProcuracao.data.toModel(viewFragment);
        
        editorProcuracao.model.insertContent(modelFragment);
        
        // Foca no editor para o usuário continuar digitando
        editorProcuracao.editing.view.focus();
    }
}
</script>
@endsection