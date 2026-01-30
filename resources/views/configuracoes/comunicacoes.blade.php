@extends('layouts.app')

@section('title', 'Designer de Procuração')

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
                    <li class="breadcrumb-item active">Designer de Procuração</li>
                </ol>
            </div>
            <h3 class="page-title"><i class="mdi mdi-file-document-edit-outline me-2"></i>Modelo de Procuração</h3>
            @if(empty($modeloComunicacao->id))
    <div class="alert alert-danger border-0 shadow-sm mb-3">
        <i class="mdi mdi-information-outline me-1"></i>
        <strong>Atenção:</strong> Você está visualizando um modelo padrão. 
        Por favor, revise o texto e clique em <strong>"Salvar Alterações"</strong> para ativar este modelo.
    </div>
@endif
        </div>
    </div>
</div>

<form method="POST" action="{{ route('configuracoes.comunicacao.save') }}" id="outorgadosForm">
    @csrf
    <input type="hidden" name="id" id="modelo_id" value="{{ $modeloComunicacao->id ?? '' }}">

    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <textarea name="conteudo" id="edit_conteudo">
                        @if(empty($modeloComunicacao->conteudo))
                            <p style="text-align:center;"><strong>COMUNICAÇÃO DE VENDA DE VEÍCULO</strong></p><p><br>
                                Eu, {INICIO_OUTORGADOS}{NOME_OUTORGADO}{FIM_OUTORGADOS}<br>&nbsp;</p><p><strong>Dados do vendedor:
                                    </strong><br>{INICIO_OUTORGADOS}<br>Nome: {NOME_OUTORGADO}</p><p>CPF: {CPF_OUTORGADO}<br>RG: 
                                        {RG_OUTORGADO}</p><p>E-mail:&nbsp;{EMAIL_OUTORGADO}<br>Telefones:&nbsp;{TELEFONE_OUTORGADO}<br>
                                            {FIM_OUTORGADOS}<br>&nbsp;</p><p>Comunico a este DETRAN/RS, nos termos do artigo 134 do 
                                                Código de Trânsito Brasileiro, que o veículo:<br>&nbsp;</p><p><strong>Dados do veículo:
                                                    </strong><br>Placa:&nbsp;{PLACA} Nº do CRV: {CRV}</p><p>Marca/Modelo:&nbsp;{MARCA_MODELO}
                                                         Cor: {COR}</p><p>Chassi:&nbsp; {CHASSI} Ano: {ANO}<br>&nbsp;</p><p><strong>foi
                                                             por mim vendido a(o) Sr(a):</strong><br>&nbsp;</p><p><strong>Dados do 
                                                                comprador:</strong><br><br>Nome: {NOME_CLIENTE}</p><p>CPF:&nbsp;{CPF_CLIENTE} 
                                                                    RG: {RG_CLIENTE}</p><p>E-mail:&nbsp;{EMAIL_CLIENTE} Telefones: {TELEFONE_CLIENTE}</p><p style="text-align:justify;">em (data da venda do veículo)&nbsp; {DIA_ATUAL} de {MES_ATUAL}&nbsp;de {ANO_ATUAL}, conforme fotocópia autenticada da Autorização para Transferência de Propriedade de Veículo – ATPV (CRV) em anexo, devidamente preenchida e com as firmas do vendedor e comprador reconhecidas.<br>&nbsp;</p><p><strong>Por ser verdade, firmo e assino o presente Comunicado de Venda.</strong></p><p style="text-align:center;">{CIDADE}, {DIA_ATUAL} de {MES_ATUAL} de {ANO_ATUAL}<br>&nbsp;</p><p style="text-align:center;">______________________________________________________________________</p><p style="text-align:center;">{NOME_CLIENTE}</p><p style="text-align:center;">&nbsp;</p>
                        @else
                          {!! $modeloComunicacao->conteudo !!}
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
                        <label class="form-label fw-bold">Outorgado Vinculado:</label>
                        {{-- Ajustado para Select Simples (apenas um outorgado) --}}
                        @php
                            $outorgadoSelecionado = null;
                            if (isset($modeloComunicacao->outorgados)) {
                                $data = $modeloComunicacao->outorgados;
                                $arr = is_array($data) ? $data : json_decode($data, true) ?? [];
                                $outorgadoSelecionado = $arr[0] ?? null; // Pega o primeiro ID do array
                            }
                        @endphp

                        <select class="form-control select2" data-toggle="select2" id="edit_outorgados" name="outorgados[]" required>
                            <option value="">Selecione o Vendedor</option>
                            @foreach ($outorgados as $out)
                                <option value="{{ $out->id }}" @if($out->id == $outorgadoSelecionado) selected @endif>
                                    {{ $out->nome_outorgado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cidade Padrão:</label>
                        <input class="form-control" name="cidade" value="{{ $modeloComunicacao->cidade ?? '' }}" required placeholder="Ex: Esteio/RS"/>
                    </div>

                    <hr class="mb-2">

                    <h5 class="header-title mb-2 text-primary">Tags Dinâmicas</h5>
                    <p class="text-muted small mb-3">Clique na tag para inserir:</p>

                    <div class="accordion accordion-flush" id="accordionTags">
                        
                        {{-- NOVO COLLAPSE ÚNICO PARA DATAS E DOCUMENTO --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold text-info" type="button" data-bs-toggle="collapse" data-bs-target="#tagDatas">
                                    DATAS E DOCUMENTO
                                </button>
                            </h2>
                            <div id="tagDatas" class="accordion-collapse collapse show">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{DATA_EXTENSO}')">{DATA_EXTENSO}</code>
                                        <code class="cursor-pointer p-1 border text-info" onclick="copyTag('{CIDADE}')">{CIDADE}</code>
                                        <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{DIA_ATUAL}')">{DIA_ATUAL}</code>
                                        <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{MES_ATUAL}')">{MES_ATUAL}</code>
                                        <code class="cursor-pointer p-1 border text-primary" onclick="copyTag('{ANO_ATUAL}')">{ANO_ATUAL}</code>
                                        <code class="cursor-pointer p-1 border text-dark" onclick="insertSignatureLine()">[LINHA ASSINATURA]</code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#tagCliente">
                                    CLIENTE (COMPRADOR)
                                </button>
                            </h2>
                            <div id="tagCliente" class="accordion-collapse collapse">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_CLIENTE}')">{NOME_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_CLIENTE}')">{CPF_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{RG_CLIENTE}')">{RG_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{TELEFONE_CLIENTE}')">{TELEFONE_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{EMAIL_CLIENTE}')">{EMAIL_CLIENTE}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{ENDERECO_CLIENTE}')">{ENDERECO_CLIENTE}</code>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-2 small fw-bold text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#tagOutorgado">
                                    DADOS DO VENDEDOR
                                </button>
                            </h2>
                            <div id="tagOutorgado" class="accordion-collapse collapse">
                                <div class="accordion-body p-2">
                                    <div class="d-flex flex-wrap gap-1">
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{NOME_OUTORGADO}')">{NOME_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{RG_OUTORGADO}')">{RG_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{CPF_OUTORGADO}')">{CPF_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{EMAIL_OUTORGADO}')">{EMAIL_OUTORGADO}</code>
                                        <code class="cursor-pointer p-1 border" onclick="copyTag('{TELEFONE_OUTORGADO}')">{TELEFONE_OUTORGADO}</code>
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
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{CRV}')">{CRV}</code>
                                        <code class="cursor-pointer p-1 border text-success" onclick="copyTag('{ANO}')">{ANO}</code>
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