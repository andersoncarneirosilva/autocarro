@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

@include('vendedores._modals.cadastro-vendedor')

@include('vendedores._modals.editar-vendedor')

{{-- Script do Toast permanece igual --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#fff',
        color: '#313a46',
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
                    <li class="breadcrumb-item active">Vendedores</li>
                </ol>
            </div>
            <h3 class="page-title">Vendedores</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Vendedores Cadastrados</h4>
                <p class="text-muted font-13 mb-0">Gerencie a equipe de vendas do sistema Alcecar.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="uil uil-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control bg-light border-0 ps-0" 
                                   placeholder="Filtrar por nome, CPF ou email...">
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-sm px-3" 
                            data-bs-toggle="modal" data-bs-target="#modalCadastroVend">
                        <i class="uil uil-plus me-1"></i> Cadastrar
                    </button>
                </div>
            </div>
        </div>

        {{-- Alterado de $outs para $vendedores conforme definido na sua Controller --}}
        @if ($vendedores->count() > 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0" id="vendedoresTable">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Nome</th>
                        <th class="py-3 text-white fw-semibold border-0">CPF</th>
                        <th class="py-3 text-white fw-semibold border-0">Status</th>
                        <th class="py-3 text-white fw-semibold border-0">Email</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($vendedores as $vendedor)
                    <tr class="align-middle user-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm border text-white fw-bold" 
                                     style="width: 38px; height: 38px; background-color: #727cf5; font-size: 16px;">
                                    {{ strtoupper(substr($vendedor->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark d-block">{{ $vendedor->name }}</span>
                                    <small class="text-muted">{{ $vendedor->telefone }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $vendedor->cpf }}</td>
                        <td>
                            <span class="badge {{ $vendedor->status == 'Ativo' ? 'bg-success-lighten text-success' : 'bg-danger-lighten text-danger' }}">
                                {{ $vendedor->status }}
                            </span>
                        </td>
                        <td>
                            @php
                                $email = $vendedor->email;
                                $emailParts = explode('@', $email);
                                $emailMasked = (count($emailParts) == 2) 
                                    ? substr($emailParts[0], 0, 2) . '****' . '@' . $emailParts[1] 
                                    : $email;
                            @endphp
                            <span class="text-muted">{{ $emailMasked }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn-action edit" data-id="{{ $vendedor->id }}" onclick="openEditModalVendedor(event)">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                
                                <form action="{{ route('vendedores.destroy', $vendedor->id) }}" method="POST" id="delete-form-{{ $vendedor->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button type="button" class="btn-action delete" onclick="confirmDelete({{ $vendedor->id }})">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="alert alert-danger bg-transparent text-danger mt-3" role="alert">
                <i class="uil uil-exclamation-octagon me-2"></i> NENHUM VENDEDOR ENCONTRADO!
            </div>
        @endif
    </div>

    {{-- Se estiver usando paginação no Controller, descomente a linha abaixo --}}
    {{-- <div class="card-footer bg-transparent border-0">
        <div class="row">
            {{ $vendedores->appends(['search' => request()->get('search', '')])->links('components.pagination') }}
        </div>
    </div> --}}
</div>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro na operação!',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#727cf5'
        });
    </script>
@endif

<script>
    // Função genérica para aplicar máscara de CPF
    function aplicarMascaraCPF(idElemento) {
        const el = document.getElementById(idElemento);
        if (el) {
            el.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        aplicarMascaraCPF('cpf_vendedor');
        aplicarMascaraCPF('edit_cpf_vendedor');
        
        // Filtro de busca simples na tabela
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#table-body tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Remover Vendedor?',
            text: "O acesso deste usuário será revogado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5c7c',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

@endsection