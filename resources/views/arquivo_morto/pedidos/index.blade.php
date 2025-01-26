@extends('layouts.app')

@section('title', 'Pedidos')

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
                @if ($errors->any())
                    <ul class="errors">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">{{ $error }}</div>
                        @endforeach
                    </ul>
                @endif
                <div class="col-sm-12">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Pedidos</h4>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>
                        </div>
                    </div>
                    @if ($pedidos)
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Fornecedor</th>
                                    <th>Ordem de compra</th>
                                    <th>Nota fiscal</th>
                                    <th>Prazo de Entrega</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pedidos as $pedi)
                                    <tr>
                                        <td>{{ $pedi->fornecedor }}</td>
                                        <td>{{ $pedi->numero_ordem }}</td>
                                        <td>{{ $pedi->numero_nota }}</td>
                                        <td>{{ Carbon\Carbon::parse($pedi->prazo_entrega)->format('d/m/y') }}</td>
                                        <td><span class="badge badge-outline-danger">{{ $pedi->status }}</span></td>
                                        <td class="table-action">
                                            
                                            <a href="{{ route('transportadoras.destroy', $pedi->id) }}"
                                                class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($empres->total() == 0)
                        <div class="alert alert-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Standard modal -->
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
        aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Nova transportadora</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @include('transportadoras.create')
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

     

    </div>
    @endsection
