@extends('layouts.app')

@section('title', 'Estoque de Produtos')

@section('content')

@include('components.toast')

{{-- Modais de Estoque --}}
@include('estoque._modals.cad')
@include('estoque._modals.edit')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Estoque</li>
                </ol>
            </div>
            <h3 class="page-title">Estoque</h3>
        </div>
    </div>
</div>

{{-- Cards de Resumo Estilo Alcecar --}}
<div class="row mb-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mt-0">Total de Itens</h6>
                        <h3 class="my-2">{{ $produtos->total() }}</h3>
                    </div>
                    <i class="mdi mdi-package-variant-closed font-24 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mt-0">Estoque Baixo</h6>
                        <h3 class="my-2 text-warning">
                            {{ $estoqueBaixoCount }}
                        </h3>
                    </div>
                    <i class="mdi mdi-alert-outline font-24 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase mt-0">Valor em Estoque</h6>
                        <h3 class="my-2 text-success">R$ {{ number_format($produtos->sum(fn($p) => $p->preco_custo * $p->estoque_atual), 2, ',', '.') }}</h3>
                    </div>
                    <i class="mdi mdi-currency-usd font-24 text-success"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Controle de Produtos</h4>
                <p class="text-muted font-13 mb-0">Gerencie insumos e produtos para venda.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('estoque.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">
                                    <i class="mdi mdi-magnify text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control bg-light border-0 ps-0" 
                                       placeholder="Buscar produto..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalCadastrarProduto">
                        <i class="mdi mdi-plus me-1"></i> Cadastrar
                    </button>
                </div>
            </div>
        </div>

        @if ($produtos->count() > 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Produto</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Categoria</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Preço Venda</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Qtd Atual</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $prod)
                        <tr class="align-middle">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded bg-primary-lighten me-3 d-flex align-items-center justify-content-center text-primary fw-bold" 
                                     style="width: 38px; height: 38px; font-size: 18px;">
                                        <i class="mdi mdi-bottle-soda"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold text-dark d-block">{{ $prod->nome }}</span>
                                        <small class="text-muted">{{ $prod->marca ?? 'Sem marca' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-muted border">{{ $prod->categoria }}</span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-dark">R$ {{ number_format($prod->preco_venda, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                @if($prod->estoque_atual <= $prod->estoque_minimo)
                                    <span class="badge bg-danger-lighten text-danger">
                                        <i class="mdi mdi-trending-down me-1"></i>{{ $prod->estoque_atual }} (Baixo)
                                    </span>
                                @else
                                    <span class="badge bg-success-lighten text-success">
                                        {{ $prod->estoque_atual }} em estoque
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" 
        class="btn-action edit btn-editar-produto" 
        data-id="{{ $prod->id }}"
        data-nome="{{ $prod->nome }}"
        data-categoria="{{ $prod->categoria }}"
        data-marca="{{ $prod->marca }}"
        data-codigo="{{ $prod->codigo_barras }}"
        data-custo="{{ number_format($prod->preco_custo, 2, ',', '.') }}"
        data-venda="{{ number_format($prod->preco_venda, 2, ',', '.') }}"
        data-atual="{{ $prod->estoque_atual }}"
        data-minimo="{{ $prod->estoque_minimo }}">
    <i class="mdi mdi-pencil"></i>
</button>
                                    
                                    <form action="{{ route('estoque.destroy', $prod->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action delete border-0 btn-delete-confirm" data-nome="{{ $prod->nome }}">
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
        <div class="mt-3">
            {{ $produtos->links() }}
        </div>
        @else
            <div class="alert alert-info bg-transparent text-info mt-3" role="alert">
                <i class="mdi mdi-information-outline me-2"></i> Nenhum produto em estoque no Alcecar.
            </div>
        @endif
    </div>
</div>

@endsection