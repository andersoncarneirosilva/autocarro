@extends('layouts.app')

@section('title', 'Colaboradores')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Colaboradores</li>
                </ol>
            </div>
            <h3 class="page-title">Colaboradores</h3>
        </div>
    </div>
</div>
<br>
        <div class="card">
          <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title">Lista de colaboradores</h4>
                <div class="dropdown">
                    <a href="{{ route('employees.create')}}" class="btn btn-primary btn-sm">Cadastrar</a>
                </div>
            </div>
            @include('employees._partials.list-colaboradores')
          </div>
        </div>
    

{{-- <!-- Standard modal -->
<div id="standard-modal" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">Cadastrar colaborador</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            @include('employees.create')
            
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal --> --}}

<script>
    // Verifique se há uma mensagem de sucesso na sessão flash
    @if(session('success'))
        // Exiba o SweetAlert de sucesso
        Swal.fire({
            icon: 'success',
            title: 'Sucesso',
            text: '{{ session('success') }}'
        });
    @endif
</script>

@endsection