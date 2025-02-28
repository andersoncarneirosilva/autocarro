@extends('layouts.app')

@section('title', 'Procurações')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pedidos</li>
                </ol>
            </div>
            <h3 class="page-title">Pedidos</h3>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            {{-- @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
                </ul>
            @endif --}}
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Pedidos cadastrados</h4>
                    <div class="dropdown">
                        
                        <a href="{{ route('pedidos.create')}}" class="btn btn-primary btn-sm">Adicionar créditos</a>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($pedidos->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Valor</th>
                                <th>Status</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>R${{ $pedido->valor }}</td>
                                    <td><span class="{{ $pedido->class_status }}">{{ $pedido->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($pedido->total() == 0)
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    {{-- <div class="row">
        {{ $pedido->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div> --}}
                                            

</div>
@endsection