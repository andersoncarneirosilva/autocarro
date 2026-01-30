@extends('layouts.app')

@section('title', 'Designer de Solicitação ATPVe')

@section('content')

{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({ 
                icon: 'success', 
                title: '{{ session('success') }}' 
            });
        @endif

        @if (session('error'))
            Toast.fire({ 
                icon: 'error', 
                title: '{{ session('error') }}' 
            });
        @endif
    });
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Designer de Solicitação ATPVe</li>
                </ol>
            </div>
            <h3 class="page-title"><i class="mdi mdi-file-document-edit-outline me-2"></i>Modelo de Solicitação ATPVe</h3>
            @if(empty($modeloAtpve->id))
    <div class="alert alert-danger border-0 shadow-sm mb-3">
        <i class="mdi mdi-information-outline me-1"></i>
        <strong>Atenção:</strong> Você está visualizando um modelo padrão. 
        Por favor, revise o texto e clique em <strong>"Salvar Alterações"</strong> para ativar este modelo.
    </div>
@endif
        </div>
    </div>
</div>

<form method="POST" action="{{ route('configuracoes.solicitacao.save') }}" id="atpveForm">
    @csrf
    {{-- Usando a variável correta vinda do controller: $modeloAtpve --}}
    <input type="hidden" name="id" id="modelo_id" value="{{ $modeloAtpve->id ?? '' }}">

    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <textarea name="conteudo" id="edit_conteudo">
                        @if(empty($modeloAtpve->conteudo))
        <p style="text-align:center;"><strong>POP 2</strong><br><strong>ANEXO 2 - REQUERIMENTO DE PREENCHIMENTO DA ATPV-e</strong></p>
        <p><br>Eu, {NOME_OUTORGADO} ,<br>CPF/CNPJ: {CPF_OUTORGADO} , requeiro ao DETRAN/RS, o preenchimento da<br>ATPV-e, relativo ao veículo Placa: {PLACA} . Chassi: {CHASSI}<br>Renavam: {RENAVAM} Marca/Modelo {MARCA_MODELO}</p>
        <p><br><strong>PROPRIETÁRIO VENDEDOR:</strong><br><strong>e-mail: {EMAIL_CLIENTE}</strong></p>
        <p><br><strong>IDENTIFICAÇÃO DO ADQUIRENTE</strong><br><strong>CPF/CNPJ: {CPF_CLIENTE}</strong><br><strong>Nome: {NOME_CLIENTE}</strong><br><strong>e-mail: {EMAIL_CLIENTE}</strong></p>
        <p><br><strong>ENDEREÇO DO ADQUIRENTE</strong><br><strong>CEP: {CEP_CLIENTE} UF: {ESTADO_CLIENTE} MUNICÍPIO: {CIDADE_CLIENTE}</strong><br><strong>Logradouro: {ENDERECO_CLIENTE} N. {NUMERO_CLIENTE}</strong><br><strong>Complemento: {COMPLEMENTO_CLIENTE} Bairro: {BAIRRO_CLIENTE}</strong></p>
        <p><br><strong>Valor: {VALOR_VENDA}</strong></p>
        <p style="text-align:center;"><br><strong>Declaro que li, estou de acordo e sou responsável pelas informações acima.</strong></p>
        <p><br>Data: {DIA_ATUAL} / {MES_ATUAL} / {ANO_ATUAL}</p>
        <p style="text-align:center;"><br><strong>__________________________________________</strong><br><strong>Assinatura do vendedor/representante legal</strong></p>
    @else
        {!! $modeloAtpve->conteudo !!}
    @endif
                    </textarea>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between">
                    <span class="text-muted small">Dica: Use as tags ao lado para automatizar o preenchimento.</span>
                    <button type="submit" id="btnSalvar" class="btn btn-primary px-4 shadow-sm">
                        <i class="mdi mdi-check-all me-1"></i> Salvar Modelo ATPVe
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-body">
                    <h5 class="header-title mb-3">Configurações</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cidade Padrão:</label>
                        <input class="form-control" name="cidade" value="{{ $modeloAtpve->cidade ?? '' }}" required placeholder="Ex: Esteio/RS"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-info small uppercase">Dados do Documento</label>
                        <div class="d-flex flex-wrap gap-1">
                            <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{DATA_EXTENSO}')">{DATA_EXTENSO}</code>
                            <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{CIDADE}')">{CIDADE}</code>
                            <code class="cursor-pointer p-1 border text-dark" onclick="insertSignatureLine()">[ASSINATURA]</code>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-info small uppercase">Tags de Data</label>
                        <div class="d-flex flex-wrap gap-1">                            
                            <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{DIA_ATUAL}')">{DIA_ATUAL}</code>
                            <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{MES_ATUAL}')">{MES_ATUAL}</code>
                            <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{ANO_ATUAL}')">{ANO_ATUAL}</code>
                        </div>
                    </div>

                    <hr class="mb-2">

                    <h5 class="header-title mb-2 text-primary">Tags Dinâmicas</h5>
                    
                    <div class="accordion accordion-flush" id="accordionTags">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#tagAdquirente">
                                    ADQUIRENTE (COMPRADOR)
                                </button>
                            </h2>
                            <div id="tagAdquirente" class="accordion-collapse collapse show">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_CLIENTE}')">{NOME_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_CLIENTE}')">{CPF_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{EMAIL_CLIENTE}')">{EMAIL_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{CEP_CLIENTE}')">{CEP_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{ENDERECO_CLIENTE}')">{ENDERECO_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{NUMERO_CLIENTE}')">{NUMERO_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{BAIRRO_CLIENTE}')">{BAIRRO_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{CIDADE_CLIENTE}')">{CIDADE_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{ESTADO_CLIENTE}')">{ESTADO_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{COMPLEMENTO_CLIENTE}')">{COMPLEMENTO_CLIENTE}</code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold text-success" type="button" data-bs-toggle="collapse" data-bs-target="#tagVeiculo">
                                    VEÍCULO
                                </button>
                            </h2>
                            <div id="tagVeiculo" class="accordion-collapse collapse">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{PLACA}')">{PLACA}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{CHASSI}')">{CHASSI}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{RENAVAM}')">{RENAVAM}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{MARCA_MODELO}')">{MARCA_MODELO}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{VALOR_VENDA}')">{VALOR_VENDA}</code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#tagVendedor">
                                    VENDEDOR (OUTORGADO)
                                </button>
                            </h2>
                            <div id="tagVendedor" class="accordion-collapse collapse">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border text-danger" onclick="copyTag('{NOME_OUTORGADO}')">{NOME_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border text-danger" onclick="copyTag('{CPF_OUTORGADO}')">{CPF_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border text-danger" onclick="copyTag('{EMAIL_OUTORGADO}')">{EMAIL_OUTORGADO}</code>
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

{{-- Estilos e Scripts do CKEditor permanecem os mesmos que você já usa no Designer de Procuração --}}
<style>
    .ck-editor__main { background-color: #f0f2f5 !important; padding: 40px 10px !important; min-height: 800px; }
    .ck-editor__editable_inline { 
        min-height: 1000px !important; width: 100% !important; max-width: 800px !important; 
        margin: 0 auto !important; padding: 2.5cm !important; background-color: white !important; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important; border: none !important; 
    }
    code { cursor: pointer; transition: 0.2s; }
    code:hover { background-color: #e9ecef; transform: scale(1.05); display: inline-block; }
</style>


<script>
let editorAtpve; // Esta é a variável global que as funções usam

document.addEventListener('DOMContentLoaded', function() {
    CKEDITOR.ClassicEditor
        .create(document.querySelector('#edit_conteudo'), {
            placeholder: 'Comece a digitar o texto do requerimento aqui...',
            // Mantive seus plugins removidos
            removePlugins: ['AIAssistant','CKBox','CKFinder','EasyImage','RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges','RealTimeCollaborativeRevisionHistory','PresenceList','Comments','TrackChanges','TrackChangesData','RevisionHistory','Pagination','WProofreader','MathType','SlashCommand','Template','DocumentOutline','FormatPainter','TableOfContents','PasteFromOfficeEnhanced','CaseChange'],
            toolbar: {
                items: ['heading','|','bold','italic', 'horizontalLine' ,'underline','strikethrough','|','fontSize','fontColor','fontBackgroundColor','|','alignment','|','outdent','indent','|','bulletedList','numberedList','|','insertTable','link','blockQuote','|','undo','redo'],
                shouldNotGroupWhenFull: true
            },
            fontSize: { options: [ 10, 12, 14, 16, 18, 20, 22 ], supportAllValues: true },
            alignment: { options: [ 'left', 'center', 'right', 'justify' ] },
        })
        .then(editor => { 
            // CORREÇÃO AQUI: Atribuir para editorAtpve, não editorProcuracao
            editorAtpve = editor; 
            console.log('Editor ATPVe carregado!');
        })
        .catch(error => { console.error(error); });

    // Ajuste no ID do formulário para bater com o HTML (atpveForm)
    $('#atpveForm').on('submit', function() {
        if (editorAtpve) {
            document.querySelector('#edit_conteudo').value = editorAtpve.getData();
        }

        const btnSalvar = document.querySelector('#btnSalvar');
        btnSalvar.disabled = true;
        btnSalvar.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            Salvando...
        `;
    });

    $('.select2').select2();
});

// Agora esta função vai encontrar a variável editorAtpve preenchida
function copyTag(tag) {
    if (editorAtpve) {
        const viewFragment = editorAtpve.data.processor.toView(tag);
        const modelFragment = editorAtpve.data.toModel(viewFragment);
        editorAtpve.model.insertContent(modelFragment);
        editorAtpve.editing.view.focus();
    } else {
        console.error('Editor ainda não foi inicializado.');
    }
}

function insertSignatureLine() {
    if (editorAtpve) {
        const signatureHtml = `
            <div style="text-align: center; margin-top: 50px;">
                <p>_______________________________________________________</p>
                <p style="font-size: 13px;">ASSINATURA DO VENDEDOR</p>
            </div>`;
        const viewFragment = editorAtpve.data.processor.toView(signatureHtml);
        const modelFragment = editorAtpve.data.toModel(viewFragment);
        editorAtpve.model.insertContent(modelFragment);
        editorAtpve.editing.view.focus();
    }
}
</script>


@endsection