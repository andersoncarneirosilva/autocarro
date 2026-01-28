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
<div class="container-fluid">
    {{-- HEADER MODERNO --}}
    <div class="row">
        <div class="col-12">
            <div class="card cta-box bg-primary text-white rounded-4 shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-xl me-4">
    @if(auth()->user()->image && Storage::disk('public')->exists(auth()->user()->image))
        <img src="{{ asset('storage/' . auth()->user()->image) }}" 
             alt="user-image" 
             class="rounded-circle img-thumbnail shadow-sm" 
             style="width: 100px; height: 100px; object-fit: cover;"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        {{-- O div abaixo só aparece se a imagem der erro de carregamento (onerror) --}}
        <div class="rounded-circle img-thumbnail bg-danger d-none align-items-center justify-content-center text-white fw-bold shadow-sm" 
             style="width: 100px; height: 100px; font-size: 2.5rem;">
            !
        </div>
    @else
        <div class="rounded-circle img-thumbnail bg-soft-light d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" 
             style="width: 100px; height: 100px; font-size: 2.5rem; border: none; background: rgba(255,255,255,0.2);">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    @endif
</div>
                        <div>
                            <h3 class="m-0 fw-bold">{{ auth()->user()->name }}</h3>
                            <p class="text-white-50 m-0 fs-5">{{ auth()->user()->email }}</p>
                            <span class="badge bg-soft-light text-white mt-2 px-3 py-2 rounded-pill">
                                <i class="mdi mdi-shield-check-outline me-1"></i> {{ auth()->user()->nivel_acesso }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- COLUNA DA ESQUERDA: DADOS PESSOAIS --}}
        <div class="col-xl-5 col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="header-title mb-4 text-dark fw-bold">
                        <i class="mdi mdi-account-circle-outline me-1 text-primary"></i> Informações Pessoais
                    </h5>
                    
                    <form action="{{ route('perfil.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Nome Completo</label>
                            <input type="text" name="name" class="form-control bg-light border-0 py-2" value="{{ auth()->user()->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">E-mail</label>
                            <input type="email" class="form-control bg-light border-0 py-2" value="{{ auth()->user()->email }}" readonly>
                            <small class="text-muted">O e-mail não pode ser alterado.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted">Foto de Perfil</label>
                            <div class="input-group">
                                <input type="file" name="image" class="form-control border-dashed p-3 text-center">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 shadow-sm">
                            <i class="mdi mdi-content-save-outline me-1"></i> Salvar Alterações
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- COLUNA DA DIREITA: SEGURANÇA --}}
        <div class="col-xl-7 col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="header-title mb-4 text-dark fw-bold">
                        <i class="mdi mdi-lock-reset me-1 text-danger"></i> Segurança da Conta
                    </h5>
                    
                    <p class="text-muted mb-4">Mantenha sua conta protegida alterando sua senha regularmente.</p>

                    <form action="{{ route('perfil.update', auth()->user()->id) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">Nova Senha</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Digite a nova senha">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted">Confirmar Senha</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password_confirm" class="form-control bg-light border-0 py-2" placeholder="Repita a nova senha">
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info bg-soft-info border-0 text-info font-13" role="alert">
                            <i class="mdi mdi-information-outline me-2"></i>
                            Deixe os campos em branco caso <strong>não queira</strong> alterar sua senha atual.
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-outline-danger px-4 py-2 rounded-3">
                                <i class="mdi mdi-shield-lock-outline me-1"></i> Atualizar Senha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos Customizados para Modernizar */
    .avatar-xl { height: 100px; width: 100px; }
    .bg-soft-light { background-color: rgba(255, 255, 255, 0.15); }
    .border-dashed { border: 2px dashed #dee2e6 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .cta-box {
        background: linear-gradient(135deg, #727cf5 0%, #4a54d4 100%) !important;
    }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.2rem rgba(114, 124, 245, 0.1);
    }
</style>

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