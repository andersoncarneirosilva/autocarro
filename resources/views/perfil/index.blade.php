@extends('layouts.app')

@section('title', 'Meu Perfil | Alcecar')

@section('content')

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

<div class="container-fluid">
    {{-- TÍTULO DA PÁGINA --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Meu perfil</li>
                    </ol>
                </div>
                <h4 class="page-title">Meu Perfil</h4>
            </div>
        </div>
    </div>

    {{-- HEADER ESTILO HYPER --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        @if(auth()->user()->image)
                                            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="user-image" class="rounded-circle img-thumbnail w-100 h-100" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle img-thumbnail bg-dark d-flex align-items-center justify-content-center w-100 h-100 text-white fw-bold fs-2">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white">{{ auth()->user()->name }}</h4>
                                        <p class="font-13 text-white-50 mb-0"><i class="bi bi-envelope me-1"></i> {{ auth()->user()->email }}</p>
                                        <p class="text-white-50 mb-0"><i class="bi bi-person-badge me-1"></i> {{ auth()->user()->nivel_acesso }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                @if(auth()->user()->nivel_acesso == 'Revenda' && isset($revenda))
                                    <a href="{{ url('/loja/' . $revenda->slug) }}" target="_blank" class="btn btn-light">
                                        <i class="mdi mdi-link-variant me-1"></i> Ver loja
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    {{-- ABAS E CONTEÚDO --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#pessoal" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                <i class="mdi mdi-account-settings-outline d-md-none d-block"></i>
                                <span class="d-none d-md-block">Dados de Acesso</span>
                            </a>
                        </li>
                        @if(auth()->user()->nivel_acesso == 'Revenda')
                        <li class="nav-item">
                            <a href="#empresa" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                <i class="mdi mdi-store d-md-none d-block"></i>
                                <span class="d-none d-md-block">Dados da Revenda</span>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        {{-- ABA SEGURANÇA --}}
                        <div class="tab-pane show active" id="pessoal">
                            <form action="{{ route('perfil.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-lock me-1"></i> Alterar Segurança</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nova Senha</label>
                                        <input type="password" name="password" class="form-control" placeholder="Preencha apenas se quiser trocar">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Confirmar Senha</label>
                                        <input type="password" name="password_confirm" class="form-control">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Trocar Foto de Perfil</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save me-1"></i> Salvar Alterações</button>
                                </div>
                            </form>
                        </div>

                        {{-- ABA REVENDA --}}
                        @if(auth()->user()->nivel_acesso == 'Revenda')
                        <div class="tab-pane" id="empresa">
                            <form action="{{ route('perfil.revenda.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-office-building me-1"></i> Informações da Loja</h5>
                                <div class="row">
                                    {{-- NOVO CAMPO DE BACKGROUND --}}
            <div class="col-12 mb-3">
                <label class="form-label">Capa da Loja (Background)</label>
                @if(isset($revenda->background))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $revenda->background) }}" class="img-fluid rounded" style="max-height: 150px; width: 100%; object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="background" class="form-control">
                <small class="text-muted">Recomendado: 1200x300px (JPG ou PNG)</small>
            </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nome da Revenda</label>
                                        <input type="text" name="nome" class="form-control" value="{{ $revenda->nome ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CNPJ</label>
                                        <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{ $revenda->CPNJ ?? ($revenda->cnpj ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">WhatsApp de Vendas</label>
                                        @php 
                                            $whatsapp = '';
                                            if (isset($revenda->fones)) {
                                                $fones = is_array($revenda->fones) ? $revenda->fones : json_decode($revenda->fones, true);
                                                $whatsapp = $fones['whatsapp'] ?? '';
                                            }
                                        @endphp
                                        <input type="text" name="whatsapp" id="whatsapp"  class="form-control" value="{{ $whatsapp }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">URL da Loja (Slug)</label>
                                        <input type="text" class="form-control bg-light" value="{{ $revenda->slug ?? '' }}" readonly>
                                    </div>
                                </div>

                                <h5 class="mb-4 text-uppercase mt-3"><i class="mdi mdi-map-marker me-1"></i> Endereço</h5>
                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label class="form-label">Logradouro</label>
                                        <input type="text" name="rua" class="form-control" value="{{ $revenda->rua ?? '' }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Número</label>
                                        <input type="text" name="numero" class="form-control" value="{{ $revenda->numero ?? '' }}">
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Cidade</label>
                                        <input type="text" name="cidade" class="form-control" value="{{ $revenda->cidade ?? '' }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label">UF</label>
                                        <input type="text" name="estado" class="form-control" value="{{ $revenda->estado ?? '' }}">
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">CEP</label>
                                        <input type="text" name="cep" class="form-control" value="{{ $revenda->cep ?? '' }}">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save me-1"></i> Atualizar Revenda</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== CNPJ =====
    const cnpjInput = document.getElementById('cnpj');

    if (cnpjInput) {
        cnpjInput.addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '').slice(0, 14);

            v = v.replace(/^(\d{2})(\d)/, '$1.$2');
            v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
            v = v.replace(/(\d{4})(\d)/, '$1-$2');

            e.target.value = v;
        });
    }

    // ===== WHATSAPP =====
    const whatsappInput = document.getElementById('whatsapp');

    if (whatsappInput) {
        whatsappInput.addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '').slice(0, 11);

            if (v.length <= 10) {
                // Telefone fixo
                v = v.replace(/^(\d{2})(\d)/, '($1) $2');
                v = v.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                // Celular
                v = v.replace(/^(\d{2})(\d)/, '($1) $2 ');
                v = v.replace(/(\d{5})(\d)/, '$1-$2');
            }

            e.target.value = v;
        });
    }

});
</script>


@endsection