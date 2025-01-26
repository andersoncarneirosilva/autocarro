@extends('layouts.app')

@section('title', 'Emprestimos')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Emprestimos</li>
                </ol>
            </div>
            <h3 class="page-title">Emprestimos</h3>
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
                        <h4 class="header-title">Emprestimos lançados</h4>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#standard-modal">Cadastrar</button>
                            <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                    class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    @if ($empres->total() != 0)
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Colaborador</th>
                                    <th>Email</th>
                                    <th>Condição</th>
                                    <th>Total</th>
                                    <th>Vencimento</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($empres as $emp)
                                    <tr>
                                        <td>{{ $emp->colaborador }}</td>
                                        <td>{{ $emp->email }}</td>
                                        <td>{{ $emp->qt_parcela }}x R${{ $emp->parcela }}</td>
                                        <td>R${{ $emp->total }}</td>
                                        <td>{{ Carbon\Carbon::parse($emp->data_vencimento)->format('d/m') }}</td>
                                        <td><span class="{{ $emp->class_status }}">{{ $emp->status }}</span></td>
                                        <td class="table-action">
                                            <a href="{{ route('parcelas.show', $emp->id) }}" class="action-icon"> <i
                                                    class="mdi mdi-eye"></i></a>

                                            @if ($emp->status == 'PENDENTE')
                                                <a href="{{ route('emprestimos.destroy', $emp->id) }}"
                                                    class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>
                                            @else
                                                <i class="action-icon mdi mdi-delete"></i>
                                            @endif
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
                        <h4 class="modal-title" id="standard-modalLabel">Novo emprestimo</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @include('emprestimos.create')
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    @endsection
