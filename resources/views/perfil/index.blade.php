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
                    <h5 class="mb-1">
                        Plano: 
                        <span class="badge rounded-pill p-1 px-2 badge-success-lighten">
                            {{ auth()->user()->plano }}
                        </span>
                    </h5>
                <hr>
                
                <h5 class="mb-1">Espaço em disco:</h5>
                <p class="text-muted font-12 mb-0">
                    {{ number_format($usedSpaceInMB, 0) }} MB usados ({{ number_format($percentUsed, 0) }}%) de
                    {{ $limitInMB }} MB
                </p>
                <div class="progress mb-3">
                    <div class="progress-bar {{ $percentUsed >= 80 ? 'bg-danger' : '' }}" role="progressbar"
                        style="width: {{ $percentUsed }}%" aria-valuenow="{{ $percentUsed }}" aria-valuemin="0"
                        aria-valuemax="100">
                        {{ number_format($percentUsed, 0) }}%
                    </div>
                </div>
                <hr>
                
                <h5 class="mb-1">Pastas</h5>
                <div id="jstree-1"></div>
                <div class="d-flex justify-content-center mt-3">
                    <button id="deleteButton" class="btn btn-danger btn-sm shadow-sm d-flex align-items-center" disabled>
                        <i class="fas fa-trash-alt me-2"></i> Excluir selecionados
                    </button>
                </div>
            </div>
        </div>
        
        
        
        <script>
            $(document).ready(function () {
                let folders = @json($folders);
        
                function renderTree(folders) {
                    if (folders.length === 0) {
                        $('#jstree-1').html('<p style="text-align: center; color: #999;">Nenhuma pasta encontrada.</p>');
                        return;
                    }
        
                    $('#jstree-1').jstree("destroy").empty().jstree({
                        'core': { 'data': folders },
                        'plugins': ["wholerow", "checkbox"]
                    }).on('ready.jstree', function () {
                        $('#jstree-1').jstree(true).get_json('#', { flat: true }).forEach(node => {
                            if (node.a_attr && node.a_attr.href) {
                                // Define ícone para arquivos
                                $('#jstree-1').jstree('set_icon', node.id, 'fa fa-file text-primary');
                            } else {
                                // Define ícone para pastas
                                $('#jstree-1').jstree('set_icon', node.id, 'fa fa-folder text-warning');
                            }
                        });
                    });
                }
        
                renderTree(folders);
        
                $('#jstree-1').on("changed.jstree", function (e, data) {
                    $('#deleteButton').prop('disabled', data.selected.length === 0);
                });
        
                $('#deleteButton').on("click", function () {
                    var selectedNodeIds = $('#jstree-1').jstree("get_selected");
                    if (selectedNodeIds.length === 0) return;
        
                    var filesToDelete = [], foldersToDelete = [];
        
                    selectedNodeIds.forEach(function(nodeId) {
                        var selectedNode = $('#jstree-1').jstree("get_node", nodeId);
                        if (selectedNode.a_attr && selectedNode.a_attr.href) {
                            filesToDelete.push(selectedNode.a_attr.href);
                        } else {
                            foldersToDelete.push(selectedNode.text);
                        }
                    });
        
                    function confirmDeletion(items, url, type) {
                        if (items.length === 0) return;
        
                        Swal.fire({
                            title: 'Você tem certeza?',
                            text: `Você deseja excluir essas ${type}?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sim, excluir!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.post(url, { 
                                    _token: "{{ csrf_token() }}", 
                                    [type === 'arquivos' ? 'fileUrls' : 'folderNames']: items 
                                }).done(function (response) {
                                    if (response.redirect) window.location.href = response.redirect;
                                    else alert(`Erro ao excluir as ${type}.`);
                                });
                            }
                        });
                    }
        
                    confirmDeletion(filesToDelete, "/perfil/excluir", "arquivos");
                    confirmDeletion(foldersToDelete, "/perfil/excluir-pasta", "pastas");
                });
            });
        </script>
        
        
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