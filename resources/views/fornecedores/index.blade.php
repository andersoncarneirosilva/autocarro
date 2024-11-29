@extends('layouts.app')

@section('title', 'Fornecedores')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Fornecedores</li>
                </ol>
            </div>
            <h3 class="page-title">Fornecedores</h3>
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
                        <h4 class="header-title">Fornecedores</h4>
                        <div class="dropdown">
                            <a href="{{ route('fornecedores.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                        </div>
                    </div>
                    @if ($forne)
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nome Fantasia</th>
                                    <th>Razão Social</th>
                                    <th>Representante</th>
                                    <th>Pedido Mínimo</th>
                                    <th>Tipo de frete</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($forne as $forn)
                                    <tr>
                                        <td>{{ $forn->nome_fantasia }}</td>
                                        <td>{{ $forn->razao_social }}</td>
                                        <td>{{ $forn->representante }}</td>
                                        <td>R${{ $forn->valor_pedido_minimo }}</td>
                                        <td>{{ $forn->tipo_frete }}</td>
                                        <td class="table-action">

                                            <a href="{{ route('fornecedores.edit', $forn->id) }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-target="#standard-modal-edit"
                                                class="font-18 text-info me-2"
                                                data-bs-placement="top"
                                                aria-label="Edit"
                                                data-bs-original-title="Editar"><i class="uil uil-pen"></i></a>
                                            <a href="{{ route('users.destroy', $forn->id) }}"
                                                class="mdi mdi-delete font-18 text-danger" 
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                aria-label="Delete"
                                                data-bs-original-title="Excluír" data-confirm-delete="true"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif($forne->total() == 0)
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
                        <h4 class="modal-title" id="standard-modalLabel">Novo fornecedor</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                       
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    @endsection
