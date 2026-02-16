@extends('layouts.app')

@section('title', 'Profissionais')

@section('content')

@include('components.toast')

@include('profissionais._modals.cad')

@include('profissionais._modals.edit')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profissionais</li>
                </ol>
            </div>
            <h3 class="page-title">Profissionais</h3>
        </div>
    </div>
</div>

{{-- Verificação de Serviços antes do Cadastro --}}
@if($servicos->isEmpty())
    <div class="alert alert-warning border-0 shadow-sm mb-3">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="mdi mdi-alert-circle-outline font-24 me-2"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading mb-1 fw-bold">Serviços Necessários</h5>
                <span>Antes de cadastrar um profissional, você deve cadastrar pelo menos um <strong>serviço</strong> no sistema.</span>
            </div>
            <div class="ms-auto">
                <a href="{{ route('servicos.index') }}" class="btn btn-warning btn-sm fw-bold">
                    <i class="mdi mdi-plus-circle-outline me-1"></i>Cadastrar Serviço
                </a>
            </div>
        </div>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Profissionais</h4>
                <p class="text-muted font-13 mb-0">Gerencie os profissionais e suas especialidades.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('profissionais.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">
                                    <i class="mdi mdi-magnify text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control bg-light border-0 ps-0" 
                                       placeholder="Nome ou E-mail..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalCadastrarFuncionario">
    <i class="mdi mdi-plus me-1"></i> Cadastrar
</button>
                </div>
            </div>
        </div>

        @if ($profissionais->count() > 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Profissional</th>
                        <th class="py-3 text-white fw-semibold border-0">Serviços</th>
                        <th class="py-3 text-white fw-semibold border-0">Contato</th>
                        <th class="py-3 text-white fw-semibold border-0">Status</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profissionais as $func)
                        @php
                            $inicialNome = substr($func->nome, 0, 1);
                            // Decodifica o JSON de serviços (caso o cast não o faça automaticamente)
                            $servicos = is_array($func->servicos) ? $func->servicos : json_decode($func->servicos, true);
                        @endphp
                        <tr class="align-middle">
                            <td>
    <div class="d-flex align-items-center">
        @if($func->foto)
            {{-- Exibe a foto caso exista --}}
            <img src="{{ asset('storage/' . $func->foto) }}" 
                 alt="{{ $func->nome }}" 
                 class="rounded-circle me-3 shadow-sm border" 
                 style="width: 38px; height: 38px; object-fit: cover;">
        @else
            {{-- Exibe a inicial caso não tenha foto --}}
            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm border text-white fw-bold" 
                 style="width: 38px; height: 38px; background-color: {{ $func->cor_agenda ?? '#727cf5' }}; font-size: 16px;">
                {{ strtoupper(substr($func->nome, 0, 1)) }}
            </div>
        @endif

        <div>
            <span class="fw-semibold text-dark d-block">{{ Str::title($func->nome) }}</span>
            <small class="text-muted">{{ $func->nive_acesso ? 'Administrador' : 'Profissional' }}</small>
        </div>
    </div>
</td>
                            <td>
                                @if(!empty($servicos))
                                    @foreach(array_slice($servicos, 0, 3) as $serv)
                                        <span class="badge bg-light text-primary border me-1">{{ $serv['nome'] }}</span>
                                    @endforeach
                                    @if(count($servicos) > 3)
                                        <span class="badge bg-light text-muted border">+{{ count($servicos) - 3 }}</span>
                                    @endif
                                @else
                                    <span class="text-muted font-12">Nenhum serviço</span>
                                @endif
                            </td>
                            <td>
                                <span class="d-block text-dark font-13"><i class="mdi mdi-email-outline"></i> {{ $func->email }}</span>
                                <span class="text-muted font-13"><i class="mdi mdi-phone"></i> {{ $func->telefone }}</span>
                            </td>
                            <td>
                                @if($func->status)
                                    <span class="badge bg-success-lighten text-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger-lighten text-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" 
        class="btn-action edit btn-editar-funcionario" 
        data-id="{{ $func->id }}"
        data-nome="{{ $func->nome }}"
        data-email="{{ $func->email }}"
        data-telefone="{{ $func->telefone }}"
        data-cor="{{ $func->cor_agenda }}"
        data-foto="{{ $func->foto }}"
        data-status="{{ $func->status }}"
        data-servicos='@json($func->servicos ?? [])'
        data-horarios='@json($func->horarios ?? (object)[])'>
    <i class="mdi mdi-pencil"></i>
</button>
                                    <form action="{{ route('profissionais.destroy', $func->id) }}" method="POST" class="d-inline form-delete">
    @csrf
    @method('DELETE')
    <button type="button" class="btn-action delete border-0 btn-delete-confirm" title="Excluir">
        <i class="mdi mdi-delete"></i>
    </button>
</form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="alert alert-info bg-transparent text-info mt-3" role="alert">
                <i class="mdi mdi-information-outline me-2"></i> Nenhum profissional cadastrado no Alcecar.
            </div>
        @endif
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intercepta o clique no botão de delete
    document.querySelectorAll('.btn-delete-confirm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');

            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não poderá ser revertida!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submete o formulário se o usuário confirmar
                    form.submit();
                }
            });
        });
    });
});
</script>


@endsection

