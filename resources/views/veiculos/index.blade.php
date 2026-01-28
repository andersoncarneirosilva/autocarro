@extends('layouts.app')

@section('content')

@include('veiculos._modals.cadastro-rapido')

{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 6000, // Aumentei um pouco o tempo para dar tempo de ler a mensagem longa
        timerProgressBar: true,
        background: '#fff',
        color: '#313a46',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if (session('success'))
        Toast.fire({ 
            icon: 'success', 
            title: '{{ session('success') }}' 
        });
    @endif

    @if (session('error'))
        Toast.fire({ 
            icon: 'error', 
            title: '{{ session('error_title') ?? "Ops!" }}', // Título em negrito
            text: '{{ session('error') }}' // Mensagem detalhada em baixo
        });
    @endif
});
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Veículos</li>
                </ol>
            </div>
            <h3 class="page-title">Veículos</h3>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body p-2">


    <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Veículos Cadastrados</h4>
                <p class="text-muted font-13 mb-0">Gerencie as informações dos veículos.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('veiculos.index') }}" method="GET" class="d-flex flex-wrap align-items-center">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="search" class="form-control" placeholder="Buscar placa, marca ou modelo..." value="{{ request('search') }}">
                        <button class="btn btn-secondary" type="submit">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('veiculos.index') }}" class="btn btn-link text-muted">Limpar filtros</a>
                    @endif
                </form>
                    </div>

                    <div class="dropdown btn-group">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="mdi mdi-plus me-1"></i>Cadastrar
                    </button>
                    <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#cadastro-rapido" class="dropdown-item">Cadastro rápido</a>
                        <a href="{{ route('veiculos.cadastro-manual') }}" class="dropdown-item">Cadastro manual</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
                @if ($veiculos->total() != 0)
                <div class="table-custom-container">
                    <table class="table table-custom table-nowrap table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Marca/Modelo</th>
                                <th>Placa</th>
                                <th>Ano/Modelo</th>
                                <th>Cor</th>
                                <th>KM</th>
                                <th>Valor</th>
                                <th>Doc</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
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
                            <td>
                                <div>
                                    <span class="fw-bold d-block">{{ $veiculo->placa }}</span>
                                </div>
                            </td>
                            <td>{{ $veiculo->ano_fabricacao }}/{{ $veiculo->ano_modelo }}</td>
                            <td>{{ $veiculo->cor }}</td>
                            <td>{{ $veiculo->kilometragem ?? 'Não consta' }}</td>
                            <td>
                                @if($veiculo->valor_oferta > 0)
                                        <small class="text-muted d-block" style="text-decoration: line-through; font-size: 0.75rem;">
                                            R$ {{ number_format($veiculo->valor, 2, ',', '.') }}
                                        </small>
                                        <span class="fw-bold text-danger">
                                            R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="fw-bold text-dark">
                                            R$ {{ number_format($veiculo->valor ?? 0, 2, ',', '.') }}
                                        </span>
                                    @endif
                            </td>

                            <td>
                                    @if($veiculo->crv === "***")
                                        <span class="badge badge-outline-danger">FÍSICO</span>
                                    @else
                                        <span class="badge badge-outline-success">DIGITAL</span>
                                    @endif
                                </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('veiculos.show', $veiculo->id) }}" 
                                    class="btn btn-sm btn-soft-primary" 
                                    title="Visualizar Detalhes">
                                        <i class="mdi mdi-eye font-18"></i>
                                    </a>

                                    <a href="javascript:void(0);" 
                                    onclick="confirmArchive({{ $veiculo->id }});" 
                                    class="btn btn-sm btn-soft-warning" 
                                    title="Arquivar Veículo">
                                        <i class="mdi mdi-archive-arrow-down-outline font-18"></i>
                                    </a>

                                    <a href="javascript:void(0);" 
                                    onclick="confirmDelete({{ $veiculo->id }})" 
                                    class="btn btn-sm btn-soft-danger" 
                                    title="Excluir Veículo">
                                        <i class="mdi mdi-trash-can-outline font-18"></i>
                                    </a>
                                </div>

                                {{-- Formulários Ocultos --}}
                                <form action="{{ route('veiculos.arquivar', $veiculo->id) }}" method="POST" id="form-arquivar-{{ $veiculo->id }}" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                </form>

                                <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" id="form-delete-{{ $veiculo->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginação Customizada Alcecar --}}
<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="text-muted font-13">
        Mostrando de <b>{{ $veiculos->firstItem() }}</b> até <b>{{ $veiculos->lastItem() }}</b> 
        de um total de <b>{{ $veiculos->total() }}</b> veículos.
    </div>
    <nav>
        {{-- Aqui chamamos o seu arquivo específico --}}
        {{ $veiculos->appends(request()->query())->links('components.pagination') }}
    </nav>
</div>

                @elseif($veiculos->total() == 0)
                    <div class="alert alert-info bg-transparent text-info" role="alert">
                        <i class="mdi mdi-information-outline me-2"></i>Nenhum veículo arquivado encontrado.
                    </div>
                @endif
    </div>
</div>

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


@endsection