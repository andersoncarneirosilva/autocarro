@extends('layouts.app')

@section('title', 'Fornecedores')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Transportadoras</li>
                </ol>
            </div>
            <h3 class="page-title">Transportadoras</h3>
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
                        <h4 class="header-title">Transportadoras</h4>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>
                        </div>
                    </div>
                    @if ($trans)
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Razão Social</th>
                                    <th>CNPJ</th>
                                    <th>Telefone</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($trans as $tran)
                                    <tr>
                                        <td>{{ $tran->razao_social }}</td>
                                        <td>{{ $tran->cnpj }}</td>
                                        <td>{{ $tran->telefone }}</td>
                                        <td class="table-action">
                                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#standard-modal-edit" 
                                                data-id-trans="{{ $tran->id }}" data-razao-social="{{ $tran->razao_social }}" 
                                                data-trans-telefone="{{ $tran->telefone }}" 
                                                data-trans-cnpj="{{ $tran->cnpj }}">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <a href="{{ route('transportadoras.destroy', $tran->id) }}"
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

        <!-- Standard modal -->
        @foreach($trans as $tran)
        <div id="standard-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Editar categoria</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-category-form" action="{{ route('category.update', ['id' => $tran->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label">Razão Social</label>
                                        <input type="text" class="form-control" name="razao_social" id="trans-razao-input">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label">Telefone</label>
                                        <input type="text" class="form-control" name="telefone" id="trans-fone-input">
                                       
                                    </div>
                                </div>
                                <div class="col-6">
                                     <label>CNPJ</label>
                                        <input type="text" class="form-control" name="cnpj" id="trans-cnpj-input">
                                </div>
                            </div>

                            <input type="hidden" name="id_trans" id="trans-id-input">
            
                            <div class="row">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <script>
            $(document).ready(function() {
                $('#standard-modal-edit').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var transId = button.data('id-trans');
                    
                    var razaoSocialTrans = button.data('razao-social');
                    var telefoneTrans = button.data('trans-telefone');
                    var cnpjTrans = button.data('trans-cnpj');

                    //console.log(telefoneTrans);
                    $('#edit-category-form').attr('action', '{{ route("transportadoras.update", ["id" => ":id_trans"]) }}'.replace(':id_trans', transId));
                    $('#trans-id-input').val(transId);
                    $('#trans-razao-input').val(razaoSocialTrans);
                    $('#trans-fone-input').val(telefoneTrans);
                    $('#trans-cnpj-input').val(cnpjTrans);
                });
            });
        </script>

    </div>
    @endsection
