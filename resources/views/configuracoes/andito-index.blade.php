@extends('layouts.app')

@section('title', 'Procuração')

@section('content')


<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Procuração</li>
                </ol>
            </div>
            <h3 class="page-title">Modelo de procuração</h3>
        </div>
    </div>
</div>

<div class="col-sm-6">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Pré-visualização</h4>
                    <div class="dropdown">
                                @if ($modeloProc->isEmpty())
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCadProc">
                                        Cadastrar
                                    </a>
                                @else
                                @foreach ($modeloProc as $modelo)
                                <a href="javascript:void(0);" 
   class="btn btn-sm btn-primary" 
   onclick="openEditProc(event)" 
   data-id="{{ $modelo->id }}">
   <i class="mdi mdi-pencil"></i> Editar Procuração
</a>
                                @endforeach
                                @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
 

</div>
</div>
</div>

@include('configuracoes.modais.modal-cadastrar')
@include('configuracoes.modais.modal-editar')


    <script>
let editorProcuracao;

document.addEventListener('DOMContentLoaded', function() {
    // Inicialização do Editor SuperBuild
    CKEDITOR.ClassicEditor
    .create(document.querySelector('#edit_conteudo'), {
        // Desativa os plugins de colaboração que causam o erro
        removePlugins: [
            'AIAssistant',
            'CKBox',
            'CKFinder',
            'EasyImage',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            'MathType',
            'SlashCommand',
            'Template',
            'DocumentOutline',
            'FormatPainter',
            'TableOfContents',
            'PasteFromOfficeEnhanced',
            'CaseChange'
        ],
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'alignment', '|', 
                'outdent', 'indent', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', 'link', 'blockQuote', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        fontSize: { options: [ 10, 12, 14, 16, 18, 20, 22 ], supportAllValues: true },
        alignment: { options: [ 'left', 'center', 'right', 'justify' ] },
        placeholder: 'Comece a escrever sua procuração aqui...'
    })
    .then(editor => { 
        editorProcuracao = editor; 
        console.log('Editor Avançado Alcecar pronto (Sem erros de colaboração).');
    })
    .catch(error => { console.error(error); });

    // Sincroniza o conteúdo antes de salvar o formulário
    $(document).on('submit', '#outorgadosForm', function() {
        if (editorProcuracao) {
            document.querySelector('#edit_conteudo').value = editorProcuracao.getData();
        }
    });

    // Inicialização do Select2 no Modal
    $('#modalEditProc').on('shown.bs.modal', function () {
        $('#edit_outorgados').select2({
            dropdownParent: $('#modalEditProc'),
            width: '100%'
        });
    });
});

function openEditProc(event) {
    event.preventDefault();
    const anchor = event.target.closest('a');
    const docId = anchor ? anchor.getAttribute('data-id') : null;

    if (!docId) return;

    $.ajax({
        url: `/modeloprocs/${docId}`,
        method: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                const data = response.data;

                // Tenta setar os dados no editor
                if (editorProcuracao) {
                    editorProcuracao.setData(data.conteudo || '');
                }
                
                $('#edit_cidade').val(data.cidade);

                const selectOutorgados = $('#edit_outorgados');
                let ids = [];
                if (data.outorgados) {
                    let raw = data.outorgados;
                    if (typeof raw === 'string') {
                        try { raw = JSON.parse(raw); if (typeof raw === 'string') raw = JSON.parse(raw); } catch(e){}
                    }
                    if (Array.isArray(raw)) {
                        ids = raw.map(item => (typeof item === 'object') ? item.id.toString() : item.toString());
                    }
                }
                selectOutorgados.val(ids).trigger('change');
                $('#modalEditProc').modal('show');
            }
        }
    });
}

function copyTag(tag) {
    if (editorProcuracao) {
        const viewFragment = editorProcuracao.data.processor.toView(tag);
        const modelFragment = editorProcuracao.data.toModel(viewFragment);
        editorProcuracao.model.insertContent(modelFragment);
        editorProcuracao.editing.view.focus();
    }
}
</script>
{{-- 
<script>
let editorProcuracao;

document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o CKEditor 5
    ClassicEditor
        .create(document.querySelector('#edit_conteudo'))
        .then(editor => { 
            editorProcuracao = editor; 
            console.log('Editor Alcecar carregado com sucesso.');
        })
        .catch(error => { console.error('Erro CKEditor:', error); });

    // Sincroniza antes do Submit
    $(document).on('submit', '#outorgadosForm', function() {
        if (editorProcuracao) {
            $('#edit_conteudo').val(editorProcuracao.getData());
        }
    });

    // Inicialização do Select2
    $('#modalEditProc').on('shown.bs.modal', function () {
        $('#edit_outorgados').select2({
            dropdownParent: $('#modalEditProc'),
            width: '100%'
        });
    });
});

function openEditProc(event) {
    event.preventDefault();
    const anchor = event.target.closest('a');
    const docId = anchor ? anchor.getAttribute('data-id') : null;

    if (!docId) return;

    $.ajax({
        url: `/modeloprocs/${docId}`,
        method: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                const data = response.data;

                // Função interna para tentar setar os dados até que o editor esteja pronto
                let tentativas = 0;
                const setEditorData = setInterval(() => {
                    if (editorProcuracao) {
                        editorProcuracao.setData(data.conteudo || '');
                        clearInterval(setEditorData);
                    }
                    tentativas++;
                    if (tentativas > 10) clearInterval(setEditorData); // Para após 10 tentativas (1 segundo)
                }, 100);

                $('#edit_cidade').val(data.cidade);

                // Processamento de Outorgados
                const selectOutorgados = $('#edit_outorgados');
                let ids = [];
                if (data.outorgados) {
                    let raw = data.outorgados;
                    if (typeof raw === 'string') {
                        try {
                            raw = JSON.parse(raw);
                            if (typeof raw === 'string') raw = JSON.parse(raw);
                        } catch (e) {}
                    }
                    if (Array.isArray(raw)) {
                        ids = raw.map(item => (typeof item === 'object') ? item.id.toString() : item.toString());
                    }
                }
                selectOutorgados.val(ids).trigger('change');

                $('#modalEditProc').modal('show');
            }
        },
        error: function() {
            alert('Erro ao carregar dados no Alcecar.');
        }
    });
}

function copyTag(tag) {
    if (editorProcuracao) {
        const viewFragment = editorProcuracao.data.processor.toView(tag);
        const modelFragment = editorProcuracao.data.toModel(viewFragment);
        editorProcuracao.model.insertContent(modelFragment);
        editorProcuracao.editing.view.focus();
    }
}
</script> --}}
    @endsection
