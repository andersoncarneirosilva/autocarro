@extends('layouts.app')

@section('content')

{{-- Toasts de sessão --}}
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('veiculos.index') }}">Veículos</a></li>
                    <li class="breadcrumb-item active">Arquivados</li>
                </ol>
            </div>
            <h3 class="page-title">Veículos Arquivados</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="row mb-3">
            <div class="col-md-8">
                <form action="{{ route('veiculos.arquivados') }}" method="GET" class="d-flex align-items-center">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="search" class="form-control" placeholder="Buscar nos arquivados..." value="{{ request('search') }}">
                        <button class="btn btn-secondary" type="submit">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('veiculos.arquivados') }}" class="btn btn-link text-muted">Limpar</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                @if ($veiculos->total() != 0)
                <div class="table-custom-container">
                    <table class="table table-custom table-nowrap table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Placa</th>
                                <th>Marca/Modelo</th>
                                <th>Ano/Modelo</th>
                                <th>Cor</th>
                                <th>KM</th>
                                <th>Câmbio</th>
                                <th>Doc</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($veiculos as $veiculo)
                            <tr>
                                <td class="d-flex align-items-center">
                                    @php
                                        $imagens = json_decode($veiculo->images);
                                        $primeiraImagem = !empty($imagens) ? $imagens[0] : null;
                                        $inicialPlaca = substr($veiculo->placa, 0, 1);
                                    @endphp

                                    <div class="me-3">
                                        @if($primeiraImagem)
                                            <img src="{{ asset('storage/' . $primeiraImagem) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #dee2e6;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white" 
                                                style="width: 40px; height: 40px; font-weight: bold; text-transform: uppercase;">
                                                {{ $inicialPlaca }}
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <span class="fw-bold d-block">{{ $veiculo->placa }}</span>
                                        <small class="badge bg-soft-secondary text-secondary">Arquivado</small>
                                    </div>
                                </td>  
                                <td>
                                    <span class="fw-bold d-block">{{ $veiculo->marca }}</span>
                                    <small class="text-muted">{{ $veiculo->modelo }}</small>
                                </td>
                                <td>{{ $veiculo->ano }}</td>
                                <td>{{ $veiculo->cor }}</td>
                            <td>{{ $veiculo->kilometragem ?? 'Não consta' }}</td>
                            <td>{{ $veiculo->cambio ?? 'Não consta' }}</td>
                                <td>
                                    @if($veiculo->crv === "***")
                                        <span class="badge badge-outline-danger">FÍSICO</span>
                                    @else
                                        <span class="badge badge-outline-success">DIGITAL</span>
                                    @endif
                                </td>
                                <td class="text-end">
    <div class="d-flex justify-content-end gap-2">
        <a href="javascript:void(0);" 
           onclick="confirmRestore({{ $veiculo->id }});" 
           class="btn btn-sm btn-soft-success" 
           title="Restaurar Veículo">
            <i class="mdi mdi-restore font-18"></i>
        </a>

        <a href="javascript:void(0);" 
           onclick="confirmDelete({{ $veiculo->id }});" 
           class="btn btn-sm btn-soft-danger" 
           title="Excluir Permanentemente">
            <i class="mdi mdi-trash-can-outline font-18"></i>
        </a>
    </div>

    {{-- Formulários Ocultos --}}
    <form action="{{ route('veiculos.desarquivar', $veiculo->id) }}" method="POST" id="form-desarquivar-{{ $veiculo->id }}" style="display:none;">
        @csrf @method('PUT')
    </form>
    
    <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" id="form-delete-{{ $veiculo->id }}" style="display:none;">
        @csrf @method('DELETE')
    </form>
</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <p class="text-muted font-13 mb-0">
                        Mostrando {{ $veiculos->count() }} de {{ $veiculos->total() }} arquivados.
                    </p>
                    <div>
                        {{ $veiculos->links() }}
                    </div>
                </div>

                @else
                    <div class="alert alert-info bg-transparent text-info" role="alert">
                        <i class="mdi mdi-information-outline me-2"></i>Nenhum veículo arquivado encontrado.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function confirmRestore(id) {
        Swal.fire({
            title: "Restaurar Veículo?",
            text: "O veículo voltará para a lista de ativos.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#10c469",
            confirmButtonText: "Sim, restaurar!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-desarquivar-' + id).submit();
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: "Excluir Permanentemente?",
            text: "Esta ação não pode ser revertida!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ff5b5b",
            confirmButtonText: "Sim, excluir!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>

@endsection