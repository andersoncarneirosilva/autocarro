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
                        @if(auth()->user()->credito > 0)
                        {{-- <div class="dropdown btn-group"> --}}
                            {{-- <button class="btn btn-primary btn-sm dropdown-toggle" 
                                type="button" data-bs-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false">Cadastrar
                            </button> --}}
                            {{-- <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end"> --}}

                                @if ($modeloProc->isEmpty())
                                    <!-- Caso não exista cadastro, exibe o botão Cadastrar -->
                                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCadProc">
                                        Cadastrar
                                    </a>
                                @else
                                <!-- Caso exista cadastro, exibe o botão Editar para cada registro -->
                                @foreach ($modeloProc as $modelo)
                                <a href="#" class="btn btn-primary btn-sm" data-id="{{ $modelo->id }}" onclick="openEditProc(event)">
                                    Editar
                                </a>
                                @endforeach
                                @endif


                            {{-- </div> --}}
                        {{-- </div> --}}

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
        
        {{-- @include('configuracoes._partials.list-outorgado')
        
        @include('configuracoes._partials.list-texto-inicial')

        @include('configuracoes._partials.list-texto-final')

        @include('configuracoes._partials.list-cidade') --}}


        @include('configuracoes._partials.list-previsualizacao')

</div>
</div>
</div>

<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadProc" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Outorgado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('modeloprocuracoes.store') }}" id="outorgadosForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Selecione os Outorgados: <span style="color: red;">*</span></label>
                        <select class="select2 form-control select2-multiple" id="outorgadosSelect"  data-toggle="select2" multiple="multiple" name="outorgados[]" data-placeholder="Escolha um ou mais ...">
                            <option value="">Selecione o cliente</option>
                            @foreach ($outorgados as $out)
                                <option value="{{ $out->id }}">{{ $out->nome_outorgado }}</option>
                            @endforeach
                        </select>
                    </div>  
                    <div class="form-group">
                        <label for="texto_inicial">Texto Inicial: <span style="color: red;">*</span></label>
                        <textarea name="texto_inicial"  class="form-control"  rows="5"></textarea>
                    </div>   
                    <div class="form-group">
                        <label for="texto_inicial">Texto Final: <span style="color: red;">*</span></label>
                        <textarea name="texto_final" class="form-control" rows="5"></textarea>
                    </div>  
                    <div class="form-group">
                        <label for="nome_outorgado" class="form-label">Cidade: <span style="color: red;">*</span></label>
                        <input class="form-control" name="cidade"/>
                    </div>         
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditProc" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar procuração</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('modeloprocuracoes.store') }}" id="outorgadosForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Selecione os Outorgados: <span style="color: red;">*</span></label>
                        <select class="select2 form-control select2-multiple" data-toggle="select2" id="edit_outorgados" multiple="multiple" name="outorgados[]" data-placeholder="Escolha um ou mais ...">
                            <option value="">Selecione o cliente</option>
                            @foreach ($outorgados as $out)
                                <option value="{{ $out->id }}">{{ $out->nome_outorgado }}</option>
                            @endforeach
                        </select>

                    </div>  
                    <div class="form-group">
                        <label for="texto_inicial">Texto Inicial: <span style="color: red;">*</span></label>
                        <textarea name="texto_inicial" id="edit_text_inicial" class="form-control"  rows="5"></textarea>
                    </div>   
                    <div class="form-group">
                        <label for="texto_inicial">Texto Final: <span style="color: red;">*</span></label>
                        <textarea name="texto_final" id="edit_text_final" class="form-control" rows="5"></textarea>
                    </div>  
                    <div class="form-group">
                        <label for="nome_outorgado" class="form-label">Cidade: <span style="color: red;">*</span></label>
                        <input class="form-control" id="edit_cidade" name="cidade"/>
                    </div>         
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>




{{-- @if($texts->total() == 0)

@else
<form action="{{ route('configuracoes.gerarProc', $text->id) }}" method="POST" enctype="multipart/form-data" target="_blank">
    @csrf
    <button type="submit" class="btn btn-primary">Visualizar modelo</button>
</form>
@endif --}}
<!-- Modal Cadastrar/Editar texto inicial-->
@include('configuracoes._partials.form-cad-texto-inicial')

@include('configuracoes._partials.form-edit-texto-inicial')

<!-- Modal Cadastro outorgado-->
{{-- @include('configuracoes._partials.form-cad-outorgado') --}}

<!-- Modal Editar outorgado-->
{{-- @include('configuracoes._partials.form-edit-outorgado') --}}

<!-- Modal Cadastrar texto poderes-->
@include('configuracoes._partials.form-cad-texto')

<!-- Modal Editar texto poderes-->
@include('configuracoes._partials.form-edit-texto')

<!-- Modal Cadastro outorgado-->
@include('configuracoes._partials.form-cad-cidade')

@include('configuracoes._partials.form-edit-cidade')




    

<script>
function openEditProc(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    const docId = event.target.closest('a')?.getAttribute('data-id');
    console.log("ID do documento:", docId);

    if (!docId) {
        Swal.fire({
            title: 'Erro!',
            text: 'ID do documento não encontrado.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Faça uma requisição AJAX para buscar os dados
    $.ajax({
    url: `/modeloprocs/${docId}`,
    method: 'GET',
    success: function(response) {
        if (response.success && response.data) {
            const data = response.data;

            // Preencher outros campos
            $('#edit_text_inicial').val(data.texto_inicial);
            $('#edit_text_final').val(data.texto_final);
            $('#edit_cidade').val(data.cidade);

            // Preencher o campo de outorgados
            const selectOutorgados = $('#edit_outorgados');
            selectOutorgados.val(null).trigger('change'); // Resetar seleção anterior

            if (data.outorgados && Array.isArray(data.outorgados)) {
                // Mapear os IDs dos outorgados para selecionar no Select2
                const outorgadosIds = data.outorgados.map(out => out.id);
                selectOutorgados.val(outorgadosIds).trigger('change');
            }

            // Mostrar o modal
            $('#modalEditProc').modal('show');
        } else {
            Swal.fire({
                title: 'Erro!',
                text: response.message || 'Não foi possível carregar os dados do modelo.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error("Erro na requisição AJAX:", textStatus, errorThrown);
        Swal.fire({
            title: 'Erro!',
            text: jqXHR.responseJSON?.message || 'Não foi possível carregar os dados.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
});

}
</script>

    @endsection
