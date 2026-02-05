@extends('layouts.app')

@section('content')

@include('components.toast')

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
                                <th>Marca/Modelo</th>
                                <th>Placa</th>
                                <th>Ano/Modelo</th>
                                <th>Cor</th>
                                <th>KM</th>
                                <th>Valor</th>
                                <th>Doc</th>
                                <th>Status</th>
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
                                    
                                        <img src="{{ asset('storage/' . $primeiraImagem) }}" 
                                            alt="Veículo" 
                                            class="rounded-circle" 
                                            style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #dee2e6;">
                                    
                                    @else
                                    
                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white" 
                                            style="width: 40px; height: 40px; font-weight: bold; font-size: 1.2rem; text-transform: uppercase;">
                                            {{ $inicialPlaca }}
                                        </div>
                                    
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
                            <td>{{ $veiculo->ano_fabricacao }}//{{ $veiculo->ano_modelo }}</td>
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
                                <td>
                                    @if($veiculo->status === "Arquivado")
                                        <span class="badge badge-outline-secondary">ARQUIVADO</span>
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

        @php
    $userLogged = auth()->user();
    $isTeste = ($userLogged->plano === 'Teste');
@endphp

@if($isTeste)
    {{-- Botão de Excluir Permanente bloqueado no Teste --}}
    <button type="button" 
            class="btn btn-sm btn-soft-secondary" 
            style="cursor: not-allowed;"
            onclick="Swal.fire({
                title: 'Ação Restrita',
                text: 'No plano Teste não é permitido excluir veículos. Faça o upgrade para ter controle total sobre seus registros!.',
                icon: 'info',
                confirmButtonColor: '#727cf5'
            })" 
            title="Exclusão permanente bloqueada">
        <i class="mdi mdi-trash-can-outline font-18"></i>
    </button>
@else
    {{-- Botão Normal para planos pagos --}}
    <a href="javascript:void(0);" 
       onclick="confirmDelete({{ $veiculo->id }});" 
       class="btn btn-sm btn-soft-danger" 
       title="Excluir Permanentemente">
        <i class="mdi mdi-trash-can-outline font-18"></i>
    </a>
@endif
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

<script>
    function confirmRestore(id) {
        Swal.fire({
            title: "Restaurar Veículo?",
            text: "O veículo voltará para a lista de ativos.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#10c469",
            confirmButtonText: "Sim, restaurar!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
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
            cancelButtonText: "Cancelar",
            reverseButtons: true // <--- ISSO coloca o Sim na DIREITA
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        });
    }
</script>

@endsection