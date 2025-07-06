@extends('layouts.app')

@section('title', 'Anuncios')

@section('content')

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif

@if (session('error'))
<script>
    toastr.error("{{ session('error') }}");
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Anúncios</li>
                </ol>
            </div>
            <h3 class="page-title">Anúncios</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Anúncios cadastrados</h4>
                    <div class="dropdown">
                        @can('access-admin') 
                    <a href="{{ route('anuncios.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                    @endcan
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($veiculos->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Foto</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Ano/Modelo</th>
                                <th>KM</th>
                                <th>Câmbio</th>
                                <th>Portas</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($veiculos as $veiculo)
                            <tr data-user-id="{{ $veiculo->id }}">
                                
                                {{-- <td>{{ $veiculo->id }}</td> --}}
                                <td class="d-flex align-items-center">
                                <div class="avatar-stack">
                                    @if($veiculo->images)
                                        @foreach(json_decode($veiculo->images) as $key => $image)
                                            @if($key < 3) <!-- Limite de 3 avatares -->
                                                <img src="{{ url("storage/{$image}") }}" class="rounded-circle avatar-img" />
                                            @endif
                                        @endforeach
                                    @else
                                        <img src="{{ url('assets/img/icon_user.png') }}" class="rounded-circle avatar-img" />
                                    @endif
                                </div>
                            </td>
                                <td>{{ $veiculo->marca }}</td>
                                <td>{{ $veiculo->modelo }}</td>
                                <td>{{ $veiculo->ano }}</td>
                                <td>{{ $veiculo->kilometragem }}</td>
                                <td>{{ $veiculo->cambio }}</td>
                                <td>{{ $veiculo->portas }}</td>
                                <td>{{ \Carbon\Carbon::parse($veiculo->created_at)->format('d/m/Y') }}</td>


                                <td class="table-action">
                                                <div class="dropdown btn-group">
                                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">

                                                        <a href="{{ route('anuncios.show', $veiculo->id) }}"
                                                            class="dropdown-item">Ver/Editar</a>

                                                        <!-- Formulário Oculto para Arquivar -->
                                                        <form action="{{ route('anuncios.arquivar', $veiculo->id) }}"
                                                            method="POST" style="display: none;"
                                                            id="form-arquivar-{{ $veiculo->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>

                                                        <!-- Link para Arquivar com SweetAlert -->
                                                        <a href="#" onclick="confirmArchive({{ $veiculo->id }});"
                                                            class="dropdown-item">
                                                            Arquivar
                                                        </a>

                                                        <!-- Link que dispara o SweetAlert -->
                                                        <a href="#" onclick="confirmDelete({{ $veiculo->id }})" class="dropdown-item text-danger">
                                                            Excluir
                                                        </a>

                                                        <!-- Formulário invisível para enviar a exclusão -->
                                                        <form id="form-delete-{{ $veiculo->id }}" action="{{ route('anuncios.destroy', $veiculo->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>

                                                        <script>
                                                            function confirmArchive(id) {
                                                                Swal.fire({
                                                                    title: "Arquivar Veículo",
                                                                    text: "Tem certeza que deseja arquivar este veículo?",
                                                                    icon: "warning",
                                                                    showCancelButton: true,
                                                                    confirmButtonText: "Sim, arquivar!",
                                                                    cancelButtonText: "Cancelar"
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        document.getElementById('form-arquivar-' + id).submit();
                                                                    }
                                                                });
                                                            }
                                                        </script>
                                                        <script>
                                                        function confirmDelete(id) {
                                                            Swal.fire({
                                                                title: "Excluir Veículo",
                                                                text: "Essa ação não pode ser desfeita. Deseja continuar?",
                                                                icon: "warning",
                                                                showCancelButton: true,
                                                                confirmButtonText: "Sim, excluir!",
                                                                cancelButtonText: "Cancelar"
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    document.getElementById('form-delete-' + id).submit();
                                                                }
                                                            });
                                                        }
                                                        </script>



                                                    </div>
                                                </div>
                                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($veiculos->total() == 0)
                        <div class="alert alert-warning bg-transparent text-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <br>
    
</div>


@endsection