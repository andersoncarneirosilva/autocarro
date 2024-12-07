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
            <h3 class="page-title">Procuração</h3>
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
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
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
                        <div class="alert alert-warning bg-transparent text-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    </div>
                        
                    @endif
            </div>
        </div>
    </div>
</div>


{{-- <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Fins e Poderes</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>

                    </div>
                </div>
                @if ($procs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Texto</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($procs as $doc)
                                <tr>
                                    <td>{{ $doc->texto_poderes }}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-id="{{ $doc->id }}" onclick="openEditModalPoderes(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($procs->total() == 0)
                        <div class="alert alert-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div> --}}


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
                    <h4 class="header-title">Texto final</h4>
                    <div class="dropdown">
                        @if ($outs->total() == 1)
                        <button type="button" class="btn btn-primary btn-sm" onclick="verificarLimiteTexto()">Cadastrar</button>

                        @else
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroTexto">Cadastrar</button>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                        @endif

                    </div>
                </div>
                
                <div class="table-responsive-sm">
                    <table class="table table-centered table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Texto</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($texts as $text)
                                <tr>
                                    <td >{{ $text->texto_final }}</td>
                                    <td >

                                        <a href="#" class="action-icon" data-id="{{ $text->id }}" onclick="openEditTextModal(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>
                                        <a href="{{ route('poderes.destroy', $text->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($texts->total() == 0)
                <div class="col-sm-12">
                    <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Texto final</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroTexto">Cadastrar</button>
                </div>
                    </div>
                    <div class="alert alert-warning bg-transparent text-warning" role="alert">
                        NENHUM RESULTADO ENCONTRADO!
                    </div>
                </div>
                    
                @endif
                   
            </div>
        </div>
    </div>
</div>


<!-- Modal para Digitar o Endereço -->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Digite o Endereço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addressForm">
                    
                    <div class="form-group">
                        <label for="inputAddress">Endereço</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Digite o endereço aqui" required>
                    </div>
                    <input type="hidden" id="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitAddress()">Gerar Procuração</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Cadastro outorgado-->
@include('configuracoes._partials.form-cad-outorgado')

<!-- Modal Editar outorgado-->
@include('configuracoes._partials.form-edit-outorgado')

<!-- Modal Cadastrar texto poderes-->
@include('configuracoes._partials.form-cad-texto')

<!-- Modal Editar texto poderes-->
@include('configuracoes._partials.form-edit-texto')






    
    
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

// function openEditModalTestemunha(event) {
//     event.preventDefault();

//     // Obtenha o ID do documento
//     //const docId = event.currentTarget.getAttribute('data-id');
//     const docId = event.target.closest('a').getAttribute('data-id');
//     // Faça uma requisição AJAX para buscar os dados
//     console.log(docId);
//     $.ajax({
//         url: `/configuracoes/${docId}`,
//         method: 'GET',
//         success: function(response) {
//             // Preencha os campos do modal com os dados do documento
//             $('#nome_testemunha').val(response.nome_testemunha);
//             $('#cpf_testemunha').val(response.cpf_testemunha);
//             $('#end_testemunha').val(response.end_testemunha);

//             // Atualize a ação do formulário para apontar para a rota de edição
//             $('#editFormTestemunha').attr('action', `/configuracoes/${docId}`);

//             // Exiba o modal
//             $('#editTestemunhaModal').modal('show');
//         },
//         error: function() {
//             Swal.fire({
//                 title: 'Erro!',
//                 text: 'Não foi possível carregar os dados.',
//                 icon: 'error',
//                 confirmButtonText: 'OK'
//             });
//         }
//     });
// }

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

</script>

    @endsection
