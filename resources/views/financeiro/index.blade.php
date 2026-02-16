@extends('layouts.app')

@section('title', 'Financeiro')

@section('content')

@include('components.toast')

@include('financeiro._modals.cad_receita')
@include('financeiro._modals.cad_despesa')
{{-- Modais Financeiros --}}
{{-- @include('admin.financeiro._modals.cad') --}}

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Financeiro</li>
                </ol>
            </div>
            <h3 class="page-title">Financeiro</h3>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mt-0">Receita Bruta</h6>
                        <h3 class="my-1 text-dark">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</h3>
                        <small class="text-muted">Mês {{ $mes }}/{{ $ano }}</small>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-primary-lighten rounded-circle">
                            <i class="mdi mdi-trending-up text-primary font-24"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 border-start border-danger border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mt-0">Despesas</h6>
                        <h3 class="my-1 text-dark">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</h3>
                        <small class="text-muted">Saídas fixas/variáveis</small>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-danger-lighten rounded-circle">
                            <i class="mdi mdi-trending-down text-danger font-24"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mt-0">Comissões</h6>
                        <h3 class="my-1 text-dark">R$ {{ number_format($totalComissoes, 2, ',', '.') }}</h3>
                        <small class="text-muted">Repasse profissionais</small>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-warning-lighten rounded-circle">
                            <i class="mdi mdi-account-cash text-warning font-24"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mt-0">Lucro Líquido</h6>
                        <h3 class="my-1 text-success fw-bold">R$ {{ number_format($lucroLiquido, 2, ',', '.') }}</h3>
                        <small class="text-muted">Saldo real no caixa</small>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-success-lighten rounded-circle">
                            <i class="mdi mdi-cash-multiple text-success font-24"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        <div class="row align-items-center mb-4 p-2">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Fluxo de Caixa</h4>
                <p class="text-muted font-13 mb-0">Listagem de entradas e saídas do mês.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <button type="button" class="btn btn-outline-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalNovaDespesa">
                        <i class="mdi mdi-minus-circle me-1"></i> Despesa
                    </button>
                    <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalNovaReceita">
                        <i class="mdi mdi-plus-circle me-1"></i> Receita
                    </button>
                </div>
            </div>
        </div>

        @if ($registros->count() > 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Descrição</th>
                        <th class="py-3 text-white fw-semibold border-0">Profissional</th>
                        <th class="py-3 text-white fw-semibold border-0">Data</th>
                        <th class="py-3 text-white fw-semibold border-0">Tipo</th>
                        <th class="py-3 text-white fw-semibold border-0">Forma</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Valor</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $reg)
                        <tr class="align-middle">
                            <td>
                                <span class="fw-semibold text-dark d-block">{{ $reg->descricao }}</span>

                            </td>
                            <td>
                                @if($reg->profissional)
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <span class="text-muted text-dark d-block">{{ $reg->profissional->nome }}</span>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted small italic">Geral / Empresa</span>
                                @endif
                            </td>
                            
                            <td>{{ $reg->data_pagamento->format('d/m/Y') }}</td>
                            <td>
                                @if($reg->tipo == 'receita')
                                    <span class="badge bg-success-lighten text-success">Receita</span>
                                @else
                                    <span class="badge bg-danger-lighten text-danger">Despesa</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary-lighten">{{ $reg->forma_pagamento ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold {{ $reg->tipo == 'receita' ? 'text-success' : 'text-danger' }}">
                                    {{ $reg->tipo == 'receita' ? '+' : '-' }} R$ {{ number_format($reg->valor, 2, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('financeiro.destroy', $reg->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn-action delete border-0 btn-delete-confirm" 
                                                data-nome="{{ $reg->descricao }}"
                                                title="Excluir">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="text-center py-5">
                <i class="mdi mdi-cash-register text-muted" style="font-size: 48px;"></i>
                <p class="text-muted mt-2">Nenhuma movimentação financeira encontrada para este período.</p>
            </div>
        @endif
    </div>
</div>

<script>
    $(document).on('click', '.btn-delete-confirm', function(e) {
    e.preventDefault();
    
    // Pega o formulário pai e o nome do item para a mensagem
    let form = $(this).closest('form');
    let nomeItem = $(this).data('nome') || 'este registro';

    Swal.fire({
        title: 'Tem certeza?',
        text: `Você deseja excluir ${nomeItem}? Esta ação não pode ser desfeita!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Vermelho (danger)
        cancelButtonColor: '#6c757d', // Cinza (secondary)
        confirmButtonText: '<i class="mdi mdi-trash-can"></i> Sim, excluir!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true, // Coloca o cancelar na esquerda
        customClass: {
            confirmButton: 'btn btn-danger px-4',
            cancelButton: 'btn btn-light px-4'
        },
        buttonsStyling: false // Permite usar as classes do Bootstrap
    }).then((result) => {
        if (result.isConfirmed) {
            // Se confirmado, submete o formulário
            form.submit();
        }
    });
});
</script>
@endsection