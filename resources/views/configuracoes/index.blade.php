@extends('layouts.app')

@section('title', 'Documentos')

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

<div class="card">
    <div class="card-body">
        <div class="row">
            @if ($outs->total() != 0)
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Outorgado</h4>
                    <div class="dropdown">
                        @if ($outs->total() >= 3)
                        <button type="button" class="btn btn-primary btn-sm" onclick="verificarLimite()">Cadastrar</button>

                        @else
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroOut">Cadastrar</button>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                        @endif
                    </div>
                </div>
                
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Endereço</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($outs as $out)
                                <tr>
                                    <td>{{ $out->nome_outorgado }}</td>
                                    <td>{{ $out->cpf_outorgado }}</td>
                                    <td>{{ $out->end_outorgado }}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-id="{{ $out->id }}" onclick="openEditModalOutorgado(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>
                                        <a href="{{ route('outorgados.destroy', $out->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($outs->total() == 0)
                    <div class="col-sm-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Outorgado</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalCadastroOut">Cadastrar</button>
                    </div>
                        </div>
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    </div>
                        
                    @endif
                
            </div>
        </div>
    </div>
</div>




<div class="card">
    <div class="card-body">
        <div class="row">
            {{-- @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
                </ul>
            @endif --}}
            @if ($texts->total() != 0)
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="header-title">Texto</h4>
            <div class="dropdown">
                @if ($texts->total() <= 1)
                    <button type="button" class="btn btn-primary btn-sm" onclick="verificarLimiteTexto()">Cadastrar</button>
                @else
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCadastroTexto">Cadastrar</button>
                @endif
            </div>
        </div>
        
        <div class="table-responsive-sm">
            <table class="table table-hover table-centered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Texto</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($texts as $text)
                        <tr>
                            <td>{!! $text->html !!}</td> <!-- Exibe o texto renderizado -->
                            <td>
                                <a href="#" class="action-icon" data-id="{{ $text->id }}" onclick="openEditTextModal(event)">
                                    <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                </a>
                                <a href="{{ route('poderes.destroy', $text->id) }}" class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        {{ $texts->links() }}
    </div>
@else
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="header-title">Texto</h4>
            <div class="dropdown">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCadastroTexto">Cadastrar</button>
            </div>
        </div>
        <div class="alert alert-danger bg-transparent text-danger" role="alert">
            NENHUM RESULTADO ENCONTRADO!
        </div>
    </div>
@endif

                   
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="row">
            @if ($cidades->total() != 0)
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Cidade da procuração</h4>
                    <div class="dropdown">
                        @if ($cidades->total() <= 1)
                        <button type="button" class="btn btn-primary btn-sm" onclick="verificarLimiteTexto()">Cadastrar</button>

                        @else
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroCidade">Cadastrar</button>
                        @endif

                    </div>
                </div>
                
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Cidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cidades as $cidade)
                                <tr>
                                    <td >{{ $cidade->cidade }}</td>
                                    <td >

                                        <a href="#" class="action-icon" data-id="{{ $cidade->id }}" onclick="openEditCidadeModal(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>
                                        <a href="{{ route('cidades.destroy', $cidade->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($cidades->total() == 0)
                <div class="col-sm-12">
                    <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Data da procuração</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroCidade">Cadastrar</button>
                </div>
                    </div>
                    <div class="alert alert-danger bg-transparent text-danger" role="alert">
                        NENHUM RESULTADO ENCONTRADO!
                    </div>
                </div>
                    
                @endif
                   
            </div>
        </div>
    </div>
</div>


@if($texts->total() == 0)

@else
<form action="{{ route('configuracoes.gerarProc', $text->id) }}" method="POST" enctype="multipart/form-data" target="_blank">
    @csrf
    <button type="submit" class="btn btn-primary">Visualizar modelo</button>
</form>
@endif

<!-- Modal Cadastro outorgado-->
@include('configuracoes._partials.form-cad-outorgado')

<!-- Modal Editar outorgado-->
@include('configuracoes._partials.form-edit-outorgado')

<!-- Modal Cadastrar texto poderes-->
@include('configuracoes._partials.form-cad-texto')

<!-- Modal Editar texto poderes-->
@include('configuracoes._partials.form-edit-texto')

<!-- Modal Cadastro outorgado-->
@include('configuracoes._partials.form-cad-cidade')

@include('configuracoes._partials.form-edit-cidade')



    
    
<script>

function verificarLimite() {
    const limiteExcedido = true; // Substitua por sua lógica de verificação real.
    
    if (limiteExcedido) {
        Swal.fire({
            icon: 'warning',
            title: 'Limite Excedido',
            text: 'Não é possível cadastrar mais outorgados.',
            confirmButtonText: 'Entendido',
        });
    } else {
        // Se o limite não estiver excedido, abre o modal.
        const modal = new bootstrap.Modal(document.getElementById('modalLimiteOut'));
        modal.show();
    }
}

function verificarLimiteTexto() {
    const limiteExcedido = true; // Substitua por sua lógica de verificação real.
    
    if (limiteExcedido) {
        Swal.fire({
            icon: 'warning',
            title: 'Limite Excedido',
            text: 'Não é possível cadastrar mais textos.',
            confirmButtonText: 'Entendido',
        });
    } else {
        // Se o limite não estiver excedido, abre o modal.
        const modal = new bootstrap.Modal(document.getElementById('modalLimiteOut'));
        modal.show();
    }
}




function openEditModalOutorgado(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    // Faça uma requisição AJAX para buscar os dados
    console.log(docId);
    $.ajax({
        url: `/outorgados/${docId}`,
        method: 'GET',
        success: function(response) {
            console.log(response);
            // Preencha os campos do modal com os dados do documento
            $('#edit_nome_outorgado').val(response.nome_outorgado);
            $('#edit_cpf_outorgado').val(response.cpf_outorgado);
            $('#edit_end_outorgado').val(response.end_outorgado);

            // Atualize a ação do formulário para apontar para a rota de edição
            $('#editForm').attr('action', `/outorgados/${docId}`);

            // Exiba o modal
            $('#editInfoModal').modal('show');
        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível carregar os dados.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

function openEditModalPoderes(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    // Faça uma requisição AJAX para buscar os dados
    //console.log(docId);
    $.ajax({
        url: `/configuracoes/${docId}`,
        method: 'GET',
        success: function(response) {
            // Preencha os campos do modal com os dados do documento
            $('#texto_poderes').val(response.texto_poderes);

            // Atualize a ação do formulário para apontar para a rota de edição
            $('#editFormPoderes').attr('action', `/configuracoes/${docId}`);

            // Exiba o modal
            $('#editPoderesModal').modal('show');
        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível carregar os dados.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

function openEditTextModal(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    // Faça uma requisição AJAX para buscar os dados
    //console.log(docId);
    $.ajax({
        url: `/poderes/${docId}`,
        method: 'GET',
        success: function(response) {
            // Preencha os campos do modal com os dados do documento
            $('#edit_texto_final').val(response.texto_final);

            // Atualize a ação do formulário para apontar para a rota de edição
            $('#editFormPoderes').attr('action', `/poderes/${docId}`);

            // Exiba o modal
            $('#editTextModal').modal('show');
        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível carregar os dados.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

function openEditCidadeModal(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    // Faça uma requisição AJAX para buscar os dados
    //console.log(docId);
    $.ajax({
        url: `/cidades/${docId}`,
        method: 'GET',
        success: function(response) {
            // Preencha os campos do modal com os dados do documento
            $('#edit_cidade').val(response.cidade);

            // Atualize a ação do formulário para apontar para a rota de edição
            $('#editFormCidade').attr('action', `/cidades/${docId}`);

            // Exiba o modal
            $('#editCidadeModal').modal('show');
        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível carregar os dados.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

</script>

    @endsection
