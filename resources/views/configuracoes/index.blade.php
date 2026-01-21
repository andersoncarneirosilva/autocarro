@extends('layouts.app')

@section('title', 'Designer de Procuração')

@section('content')

{{-- Script do Toast permanece igual --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#fff',
        color: '#313a46',
    });

    @if (session('success'))
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif

    @if (session('error'))
        Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
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
                    <li class="breadcrumb-item active">Designer de Procuração</li>
                </ol>
            </div>
            <h3 class="page-title"><i class="mdi mdi-file-document-edit-outline me-2"></i>Modelo de Procuração</h3>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('configuracoes.procuracao.save') }}" id="outorgadosForm">
    @csrf
    {{-- Input hidden para o ID do modelo (importante para o save) --}}
    <input type="hidden" name="id" id="modelo_id" value="{{ $modeloProc->first()->id ?? '' }}">

    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body p-0"> {{-- Removido padding para o fundo cinza do editor cobrir tudo --}}
                    <textarea name="conteudo" id="edit_conteudo">
                        {!! $modeloProc->first()->conteudo ?? '' !!}
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
    if (isset($modeloProc->first()->outorgados)) {
        $data = $modeloProc->first()->outorgados;
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
                        <input class="form-control" name="cidade" value="{{ $modeloProc->first()->cidade ?? '' }}" required placeholder="Ex: Esteio/RS"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-info small uppercase">Dados do Documento</label>
                        <div class="d-flex flex-wrap gap-1">
                            <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{DATA_EXTENSO}')">{DATA_EXTENSO}</code>
                            <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{CIDADE}')">{CIDADE}</code>
                            <code class="cursor-pointer p-1 border text-dark" onclick="insertSignatureLine()">[LINHA PARA ASSINATURA]</code>
                        </div>
                    </div>

                    <hr class="mb-2">

                    <h5 class="header-title mb-2 text-primary">Tags Dinâmicas</h5>
                    <p class="text-muted small mb-3">Toque na tag para inserir no texto:</p>

                    <div class="accordion accordion-flush" id="accordionTags">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#tagCliente">
                                    CLIENTE (OUTORGANTE)
                                </button>
                            </h2>
                            <div id="tagCliente" class="accordion-collapse collapse show">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_CLIENTE}')">{NOME_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_CLIENTE}')">{CPF_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{ENDERECO_CLIENTE}')">{ENDERECO_CLIENTE}</code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#tagOutorgado">
                                    REPETIDOR OUTORGADOS
                                </button>
                            </h2>
                            <div id="tagOutorgado" class="accordion-collapse collapse">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border text-danger" onclick="copyTag('{INICIO_OUTORGADOS}')">{INICIO_OUTORGADOS}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_OUTORGADO}')">{NOME_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_OUTORGADO}')">{CPF_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border text-danger" onclick="copyTag('{FIM_OUTORGADOS}')">{FIM_OUTORGADOS}</code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold text-success" type="button" data-bs-toggle="collapse" data-bs-target="#tagVeiculo">
                                    DADOS DO VEÍCULO
                                </button>
                            </h2>
                            <div id="tagVeiculo" class="accordion-collapse collapse">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{PLACA}')">{PLACA}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{CHASSI}')">{CHASSI}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{RENAVAM}')">{RENAVAM}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{MARCA_MODELO}')">{MARCA_MODELO}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{COR}')">{COR}</code>
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


<style>
    .ck-content hr.linha-tecnica {
    border: none !important;
    border-top: 1px solid #000 !important;
    height: 0 !important;
    margin: 20px 0 !important;
    opacity: 1 !important;
    background: none !important;
}

    /* Estilo para a linha de assinatura (tabela de 1px) */
    .ck-content table td[style*="background-color: #000"] {
        background-color: #000 !important;
        height: 1px !important;
        padding: 0 !important;
        border: none !important;
    }
    
    /* Remove bordas de auxílio do editor para esta tabela */
    .ck-content table[style*="width: 60%"] {
        border: none !important;
    }
</style>
<style>
    /* Estilo geral para tabelas de conteúdo */
   table {
        border-collapse: collapse;
        /* Remova ou comente a linha width: 100% se quiser que o 
           tamanho definido no JS (90%) seja respeitado fielmente */
    }

    /* Estilo para a simulação da folha no Alcecar */
    .ck-editor__editable_inline {
        /* ... seus estilos anteriores ... */
        padding: 2.5cm !important; 
    }
</style>
<style>
    /* Área cinza de fundo do editor */
    .ck-editor__main {
        background-color: #f0f2f5 !important;
        padding: 40px 10px !important;
        min-height: 800px;
    }

    /* Simulação da Folha A4 branca */
    .ck-editor__editable_inline {
        min-height: 1000px !important; 
        width: 100% !important;
        max-width: 800px !important;
        margin: 0 auto !important;
        padding: 2.5cm !important; 
        background-color: white !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
        border: none !important;
    }

    .ck-editor__top {
        position: sticky;
        top: 70px; /* Ajuste conforme a altura do seu header */
        z-index: 100;
    }

    /* Estiliza o placeholder do CKEditor */
    .ck.ck-editor__editable_inline[data-placeholder]::before {
        color: #adb5bd !important; /* Cinza suave */
        font-style: italic !important;
        font-weight: 400 !important;
    }

    code { cursor: pointer; transition: 0.2s; }
    code:hover { background-color: #e9ecef; transform: scale(1.05); display: inline-block; }
</style>
<style>
    /* Estilo para a linha de assinatura no Alcecar */
    hr {
        opacity: 1 !important;
        margin: 0 auto !important;
    }
</style>
<style>
    /* Limpa qualquer estilo de linha que possa estar vindo de fora */
    .ck-content div[style*="background-color: #000"] {
        display: block !important;
        border: none !important;
        box-shadow: none !important;
    }
</style>
<style>
    /* Garante que bordas de parágrafos dentro do editor sejam linhas simples de 1px */
    .ck-content p[style*="border-bottom"] {
        border-bottom: 10px solid #000 !important;
        display: inline-block !important;
        line-height: 0 !important;
    }
</style>

<style>
    .ck-content p[style*="border-top"] {
    border-top-width: 1px !important;
    height: 0 !important;
    line-height: 0 !important;
    padding: 0 !important;
    margin: 20px 0 !important;
}


    /* Remove qualquer padding extra que possa afastar a linha da margem */
    .ck-content p {
        margin-bottom: 0;
    }
</style>

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