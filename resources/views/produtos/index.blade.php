@extends('layouts.app')

@section('title', 'Produtos')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Produtos</li>
                </ol>
            </div>
            <h3 class="page-title">Produtos</h3>
        </div>
    </div>
</div>
<br>

<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow" style="width: 28rem;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Gerar arquivo de produtos</h5>
            <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data" id="formDoc">
                @csrf
                <div class="mb-3">
                    <label for="marcador" class="form-label">Marcador: <span style="color: red;">*</span></label>
                    <input class="form-control" type="text" name="marcador" id="marcador" required>
                </div>
                <div class="mb-3">
                    <label for="arquivo_doc" class="form-label">Arquivo: <span style="color: red;">*</span></label>
                    <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc" required>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Gerar arquivo</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Standard modal -->
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Novos produtos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



    @endsection
