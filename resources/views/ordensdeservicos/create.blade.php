@extends('layouts.app')

@section('title', 'Ordens de serviço')

@section('content')



<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ordensdeservicos.index') }}">Ordens de serviço</a></li>
                    <li class="breadcrumb-item active">Nova ordem de serviço</li>
                </ol>
            </div>
            <h3 class="page-title">Cadastrar ordem</h3>
        </div>
    </div>
</div>

{{-- Form para o cadastrar os clientes do sistema --}}
<form action="{{ route('ordensdeservicos.store') }}" method="POST" enctype="multipart/form-data" id="formProc">
    @csrf
    @include('ordensdeservicos._partials.form-cad-order')
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






