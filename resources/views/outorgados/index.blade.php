@extends('layouts.app')

@section('title', 'Outorgados')

@section('content')

@include('outorgados._partials.cadastrar-outorgado')

@include('outorgados._partials.editar-outorgado')

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
                    <li class="breadcrumb-item active">Outorgados</li>
                </ol>
            </div>
            <h3 class="page-title">Outorgados</h3>
        </div>
    </div>
</div>



<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Outorgados Cadastrados</h4>
                <p class="text-muted font-13 mb-0">Gerencie as informações dos outorgados do sistema.</p>
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

                    {{-- Ajustei o data-bs-target para o modal de Outorgados --}}
                    <button type="button" class="btn btn-primary  btn-sm px-3" 
                            data-bs-toggle="modal" data-bs-target="#modalCadastroOut">
                        <i class="uil uil-plus me-1"></i> Cadastrar
                    </button>
                </div>
            </div>
        </div>

        @if ($outs->total() != 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0" id="outorgadosTable">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Nome</th>
                        <th class="py-3 text-white fw-semibold border-0">RG</th>
                        <th class="py-3 text-white fw-semibold border-0">CPF</th>
                        <th class="py-3 text-white fw-semibold border-0">Email</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($outs as $out)
                    <tr class="align-middle user-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm border text-white fw-bold" 
                                     style="width: 38px; height: 38px; background-color: #727cf5; font-size: 16px;">
                                    {{ strtoupper(substr($out->nome_outorgado, 0, 1)) }}
                                </div>
                                <span class="fw-semibold text-dark">{{ $out->nome_outorgado }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $out->rg_outorgado }}</td>
                        <td class="text-muted">{{ $out->cpf_outorgado }}</td>
                        <td>
                            @php
                                $email = $out->email_outorgado;
                                $emailParts = explode('@', $email);
                                $emailMasked = (count($emailParts) == 2) 
                                    ? substr($emailParts[0], 0, 2) . '****' . '@' . $emailParts[1] 
                                    : $email;
                            @endphp
                            <span class="text-muted">{{ $emailMasked }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn-action edit" data-id="{{ $out->id }}" onclick="openEditModalOutorgado(event)">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                
                                <form action="{{ route('outorgados.destroy', $out->id) }}" method="POST" id="delete-form-{{ $out->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button type="button" class="btn-action delete" onclick="confirmDelete({{ $out->id }})">
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
                <i class="uil uil-exclamation-octagon me-2"></i> NENHUM RESULTADO ENCONTRADO!
            </div>
        @endif
    </div>

    <div class="card-footer bg-transparent border-0">
        <div class="row">
            {{ $outs->appends(['search' => request()->get('search', '')])->links('components.pagination') }}
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cpf_outorgado').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('edit_cpf_outorgado').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });

    function confirmDelete(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Esta ação não poderá ser revertida!",
        icon: 'warning',
        showCancelButton: true,
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
