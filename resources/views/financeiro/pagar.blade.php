@extends('layouts.app')

@section('title', 'Contas a Pagar')

@section('content')

@include('components.toast')

@include('financeiro._modals.cad_despesa')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('financeiro.index') }}">Financeiro</a></li>
                    <li class="breadcrumb-item active">Contas a Pagar</li>
                </ol>
            </div>
            <h3 class="page-title">Contas a Pagar</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        <div class="row align-items-center mb-4 p-2">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Saídas e Despesas</h4>
                <p class="text-muted font-13 mb-0">Gerencie todos os pagamentos e custos do salão.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('financeiro.pagar') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">
                                    <i class="mdi mdi-magnify text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control bg-light border-0 ps-0" 
                                       placeholder="Buscar despesa..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <button type="button" class="btn btn-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalNovaDespesa">
                        <i class="mdi mdi-minus-circle me-1"></i> Nova Despesa
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
                        <th class="py-3 text-white fw-semibold border-0">Data</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Forma</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Valor</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $reg)
                        <tr class="align-middle">
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded bg-danger-lighten me-3 d-flex align-items-center justify-content-center text-danger fw-bold" 
                                     style="width: 38px; height: 38px; font-size: 18px;">
                                        <i class="mdi mdi-cash-minus"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold text-dark d-block">{{ $reg->descricao }}</span>
                                        <small class="text-muted">Despesa Operacional</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $reg->data_pagamento->format('d/m/Y') }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-muted border">
                                    {{ $reg->forma_pagamento ?? 'Boleto' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-danger">R$ {{ number_format($reg->valor, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('financeiro.destroy', $reg->id) }}" method="POST" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action delete border-0 btn-delete-confirm" data-nome="{{ $reg->descricao }}">
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
            <div class="alert alert-danger bg-transparent text-danger mt-3" role="alert">
                <i class="mdi mdi-information-outline me-2"></i> Nenhuma despesa cadastrada.
            </div>
        @endif
    </div>
</div>
@endsection