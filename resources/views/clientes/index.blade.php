@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });

        @if (session('success'))
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif

        @if (session('error'))
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
        @endif
    });
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
                </ol>
            </div>
            <h3 class="page-title">Clientes</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        {{-- Cabeçalho idêntico ao de Outorgados --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Clientes Cadastrados</h4>
                <p class="text-muted font-13 mb-0">Gerencie as informações dos clientes do sistema.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('clientes.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">
                                    <i class="mdi mdi-magnify text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control bg-light border-0 ps-0" 
                                       placeholder="Nome ou CPF..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <a href="{{ route('clientes.index') }}" class="btn btn-light btn-sm border-0">
                                        <i class="mdi mdi-close"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <a href="{{ route('clientes.create')}}" class="btn btn-primary btn-sm px-3">
                        <i class="mdi mdi-plus me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>

        @if ($clientes->total() != 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Cliente</th>
                        <th class="py-3 text-white fw-semibold border-0">RG</th>
                        <th class="py-3 text-white fw-semibold border-0">CPF</th>
                        <th class="py-3 text-white fw-semibold border-0">Contato</th>
                        <th class="py-3 text-white fw-semibold border-0">Localização</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cli)
                        @php
                            $fone = $cli->fone;
                            $fone_formatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2.$3', $fone);
                            $link_whatsapp = "https://wa.me/+55" . preg_replace('/\D/', '', $fone);
                            $inicialNome = substr($cli->nome, 0, 1);
                        @endphp
                        <tr class="align-middle">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm border text-white fw-bold" 
                                     style="width: 38px; height: 38px; background-color: #727cf5; font-size: 16px;">
                                        {{ strtoupper($inicialNome) }}
                                    </div>
                                    <span class="fw-semibold text-dark">{{ $cli->nome }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $cli->rg }}</td>
                            <td class="text-muted">{{ $cli->cpf }}</td>
                            <td>
                                <a href="{{ $link_whatsapp }}" target="_blank" class="text-success fw-bold">
                                    <i class="mdi mdi-whatsapp font-16"></i> {{ $fone_formatado }}
                                </a>
                            </td>
                            <td>
                                <span class="d-block text-dark">{{ $cli->cidade }}/{{ $cli->estado }}</span>
                                <small class="text-muted">{{ $cli->endereco }}, {{ $cli->numero }}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('clientes.edit', $cli->id) }}" class="btn-action edit" title="Editar">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    
                                    <a href="{{ route('clientes.destroy', $cli->id) }}" class="btn-action delete" data-confirm-delete="true" title="Excluir">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="alert alert-danger bg-transparent text-danger mt-3" role="alert">
                <i class="mdi mdi-information-outline me-2"></i> NENHUM RESULTADO ENCONTRADO!
            </div>
        @endif
    </div>

    <div class="card-footer bg-transparent border-0">
        <div class="row d-flex align-items-center justify-content-between">
            <div class="col-md-6">
                <p class="text-muted font-13 mb-0">
                    Exibindo {{ $clientes->count() }} de {{ $clientes->total() }} clientes.
                </p>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                {{ $clientes->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>

@endsection