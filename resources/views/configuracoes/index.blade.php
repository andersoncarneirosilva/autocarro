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

<div class="col-6">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Pré-visualização</h4>
                    <div class="dropdown">
                        @if(auth()->user()->credito > 0)
                        <div class="dropdown btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" 
                                type="button" data-bs-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false">Cadastrar
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">

                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalVisOut" class="dropdown-item">
                                    Outorgados
                                </a>
                                
                                @if ($texts_starts->total() < 1)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalCadTextoInicial" class="dropdown-item">
                                        Texto Inicial
                                    </a>
                                @else

                                @foreach ($texts_starts as $texts_start)
                                    <a href="#" class="dropdown-item" data-id="{{ $texts_start->id }}" onclick="openEditTextoInicial(event)">
                                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#editTextInicialModal" class="dropdown-item"> --}}
                                        Editar texto inicial
                                    </a>
                                @endforeach

                                @endif

                                @if ($texts->total() < 1)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalCadastroTexto" class="dropdown-item">
                                    Cadastrar texto final
                                </a>
                                @endif

                                @foreach ($texts as $text)
                                    <a href="#" class="dropdown-item" data-id="{{ $text->id }}" onclick="openEditTextModal(event)">
                                    {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#editTextoFinalModal" > --}}
                                        Editar texto final
                                    </a>
                                @endforeach


                            </div>
                        </div>

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

<!-- Modal -->
<div class="modal fade" id="modalVisOut" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Outorgado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('configuracoes._partials.list-outorgado')                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCadastroOut" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Outorgado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('outorgados.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nome_outorgado" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome_outorgado" name="nome_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf_outorgado" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf_outorgado" name="cpf_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_outorgado" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="end_outorgado" name="end_outorgado" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Seleciona todos os campos de entrada no formulário
                        const campos = document.querySelectorAll('#nome_outorgado, #cpf_outorgado, #end_outorgado');
                
                        // Adiciona um ouvinte de evento em cada campo
                        campos.forEach(campo => {
                            campo.addEventListener('input', (event) => {
                                // Força o valor para maiúsculas
                                event.target.value = event.target.value.toUpperCase();
                            });
                        });
                    });
                </script>
                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInfoModalLabel">Editar Informações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT') <!-- Usado para edições -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_outorgado" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_nome_outorgado" name="nome_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf_outorgado" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="edit_cpf_outorgado" name="cpf_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_outorgado" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="edit_end_outorgado" name="end_outorgado" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
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
            $('#modalVisOut').modal('hide');
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

function openEditTextoInicial(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    const docId = event.target.closest('a')?.getAttribute('data-id');
    //console.log("ID do documento:", docId);

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
        url: `/textoinicial/${docId}`,
        method: 'GET',
        success: function(response) {
            //console.log("Resposta do servidor:", response);

            // Preencha os campos do modal com os dados do documento
            if (response.texto_inicio) { // Atualizado para `texto_inicio`
                $('#edit_text_inicial').val(response.texto_inicio); // Preenche o textarea
                // Atualize a ação do formulário
                $('#editFormTextoInicial').attr('action', `/textoinicial/${docId}`);
                // Exiba o modal
                $('#editTextInicialModal').modal('show');
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Texto inicial não encontrado.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
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




// Após a inicialização, use o método value para preencher o editor
function openEditTextModal(event) {
    event.preventDefault();

    // Obtém o ID do documento
    const docId = event.target.closest('a').getAttribute('data-id');

    $.ajax({
        url: `/poderes/${docId}`,
        method: 'GET', // Use GET para buscar dados
        success: function(response) {
            console.log("Resposta recebida:", response);

            // Preenche o campo do textarea com o conteúdo da resposta
            $('#edit_text_final').val(response.texto_final); // ID corrigido aqui

            // Atualiza a ação do formulário
            $('#editFormTextoFinal').attr('action', `/poderes/${docId}`);

            // Exibe o modal
            $('#editTextoFinalModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.log('Erro AJAX:', error);
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
