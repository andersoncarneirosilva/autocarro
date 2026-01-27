@extends('layouts.app')

@section('content')

@include('multas._modals.cadastro-multa')

@include('multas._modals.editar-multa')
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
                    <li class="breadcrumb-item active">Multas</li>
                </ol>
            </div>
            <h3 class="page-title">Multas</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-2">

        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Gestão de Multas</h4>
                <p class="text-muted font-13 mb-0">Monitore e gerencie infrações por veículo.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('multas.index') }}" method="GET" class="d-flex flex-wrap align-items-center">
                            <div class="input-group" style="width: 300px;">
                                <input type="text" name="search" class="form-control" placeholder="Buscar placa ou infração..." value="{{ request('search') }}">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                            </div>
                            @if(request('search'))
                                <a href="{{ route('multas.index') }}" class="btn btn-link text-muted">Limpar filtros</a>
                            @endif
                        </form>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastrarMulta">
                            <i class="mdi mdi-plus me-1"></i>Cadastrar Multa
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if ($multas->total() != 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Veículo / Placa</th>
                        <th>Infração</th>
                        <th>Data Infração</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($multas as $multa)
                    <tr>
                        <td class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white" 
                                    style="width: 40px; height: 40px; font-weight: bold; font-size: 0.9rem; text-transform: uppercase;">
                                    {{ substr($multa->veiculo->placa, -3) }}
                                </div>
                            </div>
                            <div>
                                <span class="fw-bold d-block">{{ $multa->veiculo->marca }} {{ $multa->veiculo->modelo }}</span>
                                <small class="badge bg-light text-dark border">{{ $multa->veiculo->placa }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="d-block text-truncate" style="max-width: 200px;" title="{{ $multa->descricao }}">
                                {{ $multa->descricao }}
                            </span>
                            <small class="text-muted">Cód: {{ $multa->codigo_infracao ?? 'N/A' }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($multa->data_infracao)->format('d/m/Y') }}</td>
                        <td>
   @php
    $dataVencimento = $multa->data_vencimento ? \Carbon\Carbon::parse($multa->data_vencimento)->startOfDay() : null;
    $hoje = \Carbon\Carbon::today();
    
    // Agora verifica se NÃO está pago (ou seja, pendente ou recurso)
    $naoEstaPago = in_array($multa->status, ['pendente', 'recurso']);
    
    $isVencida = $dataVencimento && $dataVencimento->lt($hoje) && $naoEstaPago;
    
    $diasParaVencer = $dataVencimento ? $hoje->diffInDays($dataVencimento, false) : null;
    
    $venceEmBreve = $dataVencimento && $diasParaVencer >= 0 && $diasParaVencer <= 7 && $naoEstaPago && !$isVencida;
@endphp

    @if($dataVencimento)
        <div class="d-flex align-items-center">
            <span class="fw-bold text-dark">
                {{ $dataVencimento->format('d/m/Y') }}
            </span>

            @if($isVencida)
                <i class="mdi mdi-alert-circle text-danger ms-1" title="Vencida!" data-bs-toggle="tooltip"></i>
            @elseif($venceEmBreve)
                <i class="mdi mdi-clock-outline text-warning ms-1" title="Vence em breve" data-bs-toggle="tooltip"></i>
            @endif
        </div>
        
        @if($isVencida)
            <small class="text-danger d-block font-11 fw-bold">
                <i class="mdi mdi-arrow-right"></i> Débito Atrasado
            </small>
        @elseif($venceEmBreve)
            <small class="text-warning d-block font-11 fw-bold">
                <i class="mdi mdi-timer-sand"></i> 
                @if($diasParaVencer == 0)
                    Vence Hoje!
                @else
                    Vence em {{ (int)$diasParaVencer }} {{ $diasParaVencer == 1 ? 'dia' : 'dias' }}
                @endif
            </small>
        @elseif($multa->status == 'pago')
            <small class="text-success d-block font-11">
                <i class="mdi mdi-check"></i> Pago
            </small>
        @endif
    @else
        <span class="text-muted">---</span>
    @endif
</td>
                        <td>
                            <span class="fw-bold text-dark">
                                R$ {{ number_format($multa->valor, 2, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClasses = [
                                    'pago' => 'badge-outline-success',
                                    'pendente' => 'badge-outline-danger',
                                    'recurso' => 'badge-outline-warning'
                                ];
                            @endphp
                            <span class="badge {{ $statusClasses[$multa->status] ?? 'badge-outline-secondary' }}">
                                {{ strtoupper($multa->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                {{-- Botão Marcar como Pago --}}
                                @if($multa->status !== 'pago')
                                    <button type="button" class="btn btn-sm btn-soft-success" title="Marcar como Pago" onclick="confirmarPagamento({{ $multa->id }})">
                                        <i class="mdi mdi-check-bold font-18"></i>
                                    </button>
                                    
                                    <form id="form-pagar-{{ $multa->id }}" action="{{ route('multas.pagar', $multa->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif

                                {{-- Botão Editar --}}
                                <button type="button" class="btn btn-sm btn-soft-info" title="Editar" onclick="editarMulta({{ json_encode($multa) }})">
                                    <i class="mdi mdi-pencil font-18"></i>
                                </button>

                                {{-- Botão Excluir --}}
                                <a href="javascript:void(0);" onclick="confirmDeleteMulta({{ $multa->id }})" class="btn btn-sm btn-soft-danger" title="Excluir">
                                    <i class="mdi mdi-trash-can-outline font-18"></i>
                                </a>

                                {{-- FORMULÁRIO DE EXCLUSÃO (Deve estar aqui ou o ID deve bater) --}}
                                <form action="{{ route('multas.destroy', $multa->id) }}" method="POST" id="form-delete-multa-{{ $multa->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginação Customizada Alcecar --}}
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div class="text-muted font-13">
                Mostrando <b>{{ $multas->firstItem() }}</b> até <b>{{ $multas->lastItem() }}</b> 
                de <b>{{ $multas->total() }}</b> multas.
            </div>
            <nav>
                {{ $multas->appends(request()->query())->links('components.pagination') }}
            </nav>
        </div>

        @else
            <div class="alert alert-info bg-transparent text-info" role="alert">
                <i class="mdi mdi-information-outline me-2"></i>Nenhuma multa encontrada.
            </div>
        @endif
    </div>
</div>

<script>
   function confirmarPagamento(id) {
    Swal.fire({
        title: 'Confirmar Pagamento?',
        text: "Deseja marcar esta multa como PAGA no sistema alcecar?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745', // Cor do sucesso
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="mdi mdi-check me-1"></i> Sim, está paga!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true // Inverte para o "Sim" ficar na direita
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostra um loading enquanto processa
            Swal.fire({
                title: 'Processando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            document.getElementById('form-pagar-' + id).submit();
        }
    });
}

// Aproveitando, se quiser padronizar o Delete com SweetAlert:
function confirmDeleteMulta(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Esta multa será removida permanentemente do alcecar!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#fa5c7c', // Cor de perigo
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('form-delete-multa-' + id);
            
            if (form) {
                // Feedback visual de carregamento
                Swal.fire({
                    title: 'Excluindo...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                form.submit();
            } else {
                // Isso ajuda a debugar se o formulário sumiu da tela
                console.error('Formulário de exclusão não encontrado para o ID: ' + id);
                Swal.fire('Erro!', 'Não foi possível encontrar o formulário de exclusão.', 'error');
            }
        }
    });
}
</script>

@endsection