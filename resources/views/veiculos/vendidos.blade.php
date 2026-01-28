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
    <div class="card-body p-2">

        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Veículos Arquivados</h4>
                <p class="text-muted font-13 mb-0">Gerencie as informações dos veículos.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('veiculos.arquivados') }}" method="GET" class="d-flex flex-wrap align-items-center">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="search" class="form-control" placeholder="Buscar placa, marca ou modelo..." value="{{ request('search') }}">
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
            </div>
        </div>

                @if ($veiculos->total() != 0)
                <div class="table-custom-container">
                    <table class="table table-custom table-nowrap table-hover mb-0">
    <thead class="table-dark">
        <tr>
            <th>Veículo</th>
            <th>Placa</th>
            <th>Comprador</th>
            <th>Data Venda</th>
            <th>Valor de Venda</th>
            <th>Vendedor</th>
            <th class="text-end">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($veiculos as $veiculo)
        <tr>
            <td class="d-flex align-items-center">
                                @php
                                    // Decodifica o JSON de imagens e pega a primeira
                                    $imagens = json_decode($veiculo->images);
                                    $primeiraImagem = !empty($imagens) ? $imagens[0] : null;
                                    
                                    // Pega a primeira letra da placa para o avatar reserva
                                    $inicialPlaca = substr($veiculo->placa, 0, 1);
                                @endphp

                                <div class="me-3">
                                    @if($primeiraImagem)
                                    <a href="{{ route('veiculos.show', $veiculo->id) }}" class="dropdown-item">
                                        <img src="{{ asset('storage/' . $primeiraImagem) }}" 
                                            alt="Veículo" 
                                            class="rounded-circle" 
                                            style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #dee2e6;">
                                    </a>
                                    @else
                                    <a href="{{ route('veiculos.show', $veiculo->id) }}" class="dropdown-item">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" 
                                            style="width: 40px; height: 40px; font-weight: bold; font-size: 1.2rem; text-transform: uppercase;">
                                            {{ $inicialPlaca }}
                                        </div>
                                    </a>
                                    @endif
                                </div>

                                <div>
                                    <span class="fw-bold d-block">{{ $veiculo->marca }}</span>
                                    <small class="text-muted">{{ $veiculo->modelo }}</small>
                                    
                                </div>
                            </td>
            <td><span class="badge bg-light text-dark border">{{ $veiculo->placa }}</span></td>
            <td>
                {{-- Nome do cliente vindo do relacionamento --}}
                <span class="fw-semibold text-dark">{{ $veiculo->cliente->nome ?? 'N/D' }}</span>
                <small class="d-block text-muted">{{ $veiculo->cliente->cpf ?? '' }}</small>
            </td>
            <td>{{ $veiculo->data_venda ? $veiculo->data_venda->format('d/m/Y') : '---' }}</td>
            <td>
                <span class="text-success fw-bold">R$ {{ number_format($veiculo->valor_venda, 2, ',', '.') }}</span>
                @if($veiculo->valor_venda < $veiculo->valor)
                    <small class="d-block text-danger" style="font-size: 0.7rem;">
                        <i class="mdi mdi-arrow-down"></i> Desc. R$ {{ number_format($veiculo->valor - $veiculo->valor_venda, 2, ',', '.') }}
                    </small>
                @endif
            </td>
            <td>
                <span class="badge badge-info-lighten">{{ $veiculo->vendedor->name ?? 'Admin' }}</span>
            </td>
            <td class="text-end">
    <div class="d-flex justify-content-end gap-1">
        {{-- Visualizar Detalhes - MANTIDO --}}
        <a href="{{ route('veiculos.show', $veiculo->id) }}" class="btn btn-sm btn-soft-primary" title="Ver Detalhes">
            <i class="mdi mdi-eye-outline font-16"></i>
        </a>
        
        {{-- Botão para Estornar/Desarquivar --}}
        <button type="button" class="btn btn-sm btn-soft-warning" 
                onclick="confirmDesarquivar({{ $veiculo->id }})" title="Voltar para Estoque">
            <i class="mdi mdi-archive-arrow-up-outline font-16"></i>
        </button>

        {{-- Botão para Excluir Permanente --}}
        <button type="button" onclick="confirmDelete({{ $veiculo->id }});" class="btn btn-sm btn-soft-danger" title="Excluir">
            <i class="mdi mdi-trash-can-outline font-16"></i>
        </button>
    </div>

    <form action="{{ route('veiculos.desarquivar', $veiculo->id) }}" 
          method="POST" 
          id="form-desarquivar-{{ $veiculo->id }}" 
          style="display:none;">
        @csrf 
        @method('PUT')
    </form>
    
    <form action="{{ route('veiculos.destroy', $veiculo->id) }}" 
          method="POST" 
          id="form-delete-{{ $veiculo->id }}" 
          style="display:none;">
        @csrf 
        @method('DELETE')
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

<script>

function confirmDesarquivar(id) {
    Swal.fire({
        title: "Voltar para o estoque?",
        text: "O veículo voltará a ficar disponível e os dados da venda atual serão limpos.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#f1b44c",
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