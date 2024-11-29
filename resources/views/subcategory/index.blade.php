@extends('layouts.app')

@section('title', 'Categorias')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Subcategorias</li>
                    </ol>
                </div>
                <h3 class="page-title">Subcategorias</h3>
            </div>
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Subcategorias</h4>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#standard-modal">Cadastrar</button>
                            <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                    class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Subcategoria</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($subs as $sub)
                                <tr>
                                    <td>{{ $sub->nome_cat }}</td>
                                    <td>{{ $sub->nome_subcat }}</td>
                                    <td>{{ Carbon\Carbon::parse($sub->create_at)->format('d/m') }}</td>
                                    <td class="table-action">
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#standard-modal-edit" 
                                        data-subegory-id="{{ $sub->id }}" data-nome-doc="{{ $sub->nome_subcat }}"><i class="mdi mdi-pencil"></i></button>
                                        <a href="{{ route('subcategory.destroy', $sub->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>

        <!-- Standard modal -->
        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Nova subcategoria</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @include('subcategory.create')
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Standard modal -->

        <!-- Standard modal -->
        @foreach($subs as $sub)
        <div id="standard-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Editar categoria</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-category-form" action="{{ route('category.update', ['id' => $sub->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
        
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="nome-doc-input">Nome da categoria</label>
                                        <input type="text" name="nome_doc" value="" class="form-control" id="nome-doc-input">
                                    </div>
                                </div>
                            </div>
        
                            <input type="hidden" name="category_id" id="category-id-input">
        
                            <br>
                            <div class="row">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
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
                    var categoryId = button.data('category-id');
                    var nomeDoc = button.data('nome-doc');
        
                    $('#edit-category-form').attr('action', '{{ route("category.update", ["id" => ":category_id"]) }}'.replace(':category_id', categoryId));
                    $('#category-id-input').val(categoryId);
                    $('#nome-doc-input').val(nomeDoc);
                });
            });
        </script>
@endsection
