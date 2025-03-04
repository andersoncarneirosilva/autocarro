@extends('layouts.app')

@section('title', 'Perfil')

@section('content')

<script>
    $(document).ready(function () {
        // Exibe o toast de sucesso ou erro, se houver uma mensagem na sessão
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @elseif(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    });
</script>


    

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Meu perfil</li>
                </ol>
            </div>
            <h3 class="page-title">Meu perfil</h3>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-body">
                <span class="float-start m-2 me-4">
                    @if(auth()->user()->image)
                <img src="storage/{{ auth()->user()->image }}" class="rounded-circle img-thumbnail" style="height: 100px;">
                @else
                <img src="{{ url("assets/img/icon_user.png") }}" alt="" class="rounded-circle avatar-lg img-thumbnail">
                @endif
                
                </span>
                <div class="">
                    <h4 class="mt-1 mb-1">{{ auth()->user()->name }}</h4>
                    <p class="font-13"> {{ auth()->user()->email }}</p>

                    <ul class="mb-0 list-inline">
                        <li class="list-inline-item me-3">
                            <h5 class="mb-1">Fone</h5>
                            <p class="mb-0 font-13">{{ auth()->user()->telefone }}</p>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="mb-1">Perfil</h5>
                            <p class="mb-0 font-13">{{ auth()->user()->perfil }}</p>
                        </li>
                    </ul>
                </div>
                <!-- end div-->
            </div> <!-- end card-body-->
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="mb-1">Plano: <span class="badge rounded-pill p-1 px-2 badge-success-lighten"> {{ auth()->user()->plano }}</span></h5>
                <hr>
                <h5 class="mb-1">Pastas</h5>
                <div id="jstree-1"></div>

                <!-- Botão para excluir o item selecionado -->
<button id="deleteButton" class="btn btn-danger mt-3" disabled>Excluir Selecionado</button>

<script>
    $(document).ready(function () {
        let folders = @json($folders);

        $('#jstree-1').jstree("destroy").empty(); // Remove qualquer árvore anterior
        $('#jstree-1').jstree({
            'core': {
                'data': folders // Dados da árvore
            },
            "plugins": ["wholerow", "checkbox"], // Habilita a seleção
        });

        // Evento para habilitar o botão de exclusão quando um item for selecionado
        $('#jstree-1').on("changed.jstree", function (e, data) {
            if (data.selected.length > 0) {
                $('#deleteButton').prop('disabled', false); // Habilita o botão
            } else {
                $('#deleteButton').prop('disabled', true); // Desabilita o botão
            }
        });

        // Evento para excluir os itens selecionados
        $('#deleteButton').on("click", function () {
            var selectedNodeIds = $('#jstree-1').jstree("get_selected"); // Obtém os IDs dos itens selecionados

            if (selectedNodeIds.length > 0) {
                var filesToDelete = [];
                var foldersToDelete = [];

                // Se for um arquivo ou pasta
                selectedNodeIds.forEach(function(nodeId) {
                    var selectedNode = $('#jstree-1').jstree("get_node", nodeId); // Obtém o nó

                    if (selectedNode.a_attr && selectedNode.a_attr.href) {
                        // Se for um arquivo
                        filesToDelete.push(selectedNode.a_attr.href);
                    } else {
                        // Se for uma pasta
                        foldersToDelete.push(selectedNode.text);
                    }
                });

                // Solicitação para excluir arquivos
                if (filesToDelete.length > 0) {
                    Swal.fire({
                        title: 'Você tem certeza?',
                        text: "Você deseja excluir esses arquivos?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sim, excluir!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/perfil/excluir", // Rota para exclusão de arquivos
                                method: "POST",
                                data: { fileUrls: filesToDelete, _token: "{{ csrf_token() }}" },
                                success: function (response) {
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    } else {
                                        alert("Erro ao excluir os arquivos.");
                                    }
                                }
                            });
                        }
                    });
                }

                // Solicitação para excluir pastas
                if (foldersToDelete.length > 0) {
                    Swal.fire({
                        title: 'Você tem certeza?',
                        text: "Você deseja excluir essas pastas?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sim, excluir!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/perfil/excluir-pasta", // Rota para exclusão de pastas
                                method: "POST",
                                data: { folderNames: foldersToDelete, _token: "{{ csrf_token() }}" },
                                success: function (response) {
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    } else {
                                        alert("Erro ao excluir as pastas.");
                                    }
                                }
                            });
                        }
                    });
                }
            }
        });
    });
</script>







                
                
                
                
                
                
                
                
                
                
            </div>
        </div>
        
    </div> <!-- end col-->

    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('perfil.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                <h5 class="mb-3 text-uppercase p-2"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="userpassword" class="form-label">Confirmar senha</label>
                                <input type="password" class="form-control" name="password_confirm">
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Foto do perfil</label>
                                <input class="form-control" type="file" name="image">
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                    </div>
                </form>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
</div>

@endsection