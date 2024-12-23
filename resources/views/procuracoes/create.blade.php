@extends('layouts.app')

@section('title', 'Clientes')

@section('content')



<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Procuração</a></li>
                    <li class="breadcrumb-item active">Nova procuração</li>
                </ol>
            </div>
            <h3 class="page-title">Cadastrar procuração</h3>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Atenção - </strong>Todos os campos são obrigatórios.
    </div>
@endif

{{-- Form para o cadastrar os clientes do sistema --}}
<form action="{{ route('procuracoes.store') }}" method="POST" enctype="multipart/form-data" id="formProc">
    @csrf
    @include('procuracoes._partials.form-cad-proc')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formProc');
        const nome = document.getElementById('nome_cliente');
        
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const nomeInp = nome.value.trim();
            if (!nomeInp) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Por favor, preencha o nome.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            form.submit();
        });
    });
</script>

@endsection






