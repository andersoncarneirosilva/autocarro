@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

{{-- Modal de Cadastro (Único) --}}
@include('users._partials.cadastrar-usuario')

{{-- Scripts de Alerta (Toast) --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
    });
    @if (session('success')) Toast.fire({ icon: 'success', title: '{{ session('success') }}' }); @endif
    @if (session('error')) Toast.fire({ icon: 'error', title: '{{ session('error') }}' }); @endif
});
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h3 class="page-title">Usuários</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2"> 
        <div class="row align-items-center mb-4 p-2">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Usuários Cadastrados</h4>
                <p class="text-muted font-13 mb-0">Gerencie a equipe do Alcecar.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0"><i class="uil uil-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control bg-light border-0 ps-0" placeholder="Filtrar equipe...">
                        </div>
                    </div>

                    @php
                        $userLogged = auth()->user();
                        $limites = ['Teste' => 1];
                        $totalUsers = \App\Models\User::where('empresa_id', $userLogged->empresa_id ?? $userLogged->id)->count();
                        $limiteAtingido = $totalUsers >= ($limites[$userLogged->plano] ?? 1);
                    @endphp

                    @if($limiteAtingido)
                        <div class="alert alert-warning py-1 px-2 mb-0 font-13">
                            Limite atingido. <a href="{{ route('planos.index') }}" class="fw-bold">Upgrade?</a>
                        </div>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastrarUsuario">
                            <i class="uil-plus"></i> Cadastrar
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0" id="userTable">
                <thead class="bg-dark">
                    <tr>
                        <th class="text-white border-0">Usuário</th>
                        <th class="text-white border-0">Telefone</th>
                        <th class="text-white border-0">Acesso</th>
                        <th class="text-white border-0">Status</th>
                        <th class="text-white border-0">Ações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @forelse ($users as $user)
                    <tr class="align-middle user-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle me-2 d-flex align-items-center justify-content-center bg-primary text-white fw-bold" style="width: 35px; height: 35px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="d-block fw-semibold text-dark user-name">{{ $user->name }}</span>
                                    <small class="text-muted user-email">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $user->telefone) }}" target="_blank" class="text-success">
                                <i class="uil uil-whatsapp"></i> {{ $user->telefone }}
                            </a>
                        </td>
                        <td><span class="badge badge-outline-info rounded-pill">{{ $user->nivel_acesso }}</span></td>
                        <td>
                            <span class="badge bg-{{ $user->status == 'Ativo' ? 'success' : 'secondary' }}-lighten text-{{ $user->status == 'Ativo' ? 'success' : 'secondary' }} rounded-pill">
                                {{ $user->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Botão Editar --}}
                                <button type="button" class="btn-action edit" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario{{ $user->id }}">
                                    <i class="uil uil-pen"></i>
                                </button>
                                
                                {{-- Botão Excluir --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-action delete btn-delete-confirm">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- INCLUSÃO DO MODAL DE EDIÇÃO DENTRO DO LOOP --}}
                    @include('users._partials.editar-usuario', ['user' => $user])

                    @empty
                    <tr><td colspan="5" class="text-center py-4">Nenhum usuário encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPTS UNIFICADOS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // 1. MÁSCARAS GLOBAIS (Funcionam em todos os modais novos e velhos)
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('tel-mask')) {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            if (v.length > 10) v = v.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
            else v = v.replace(/^(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
            e.target.value = v;
        }
        if (e.target.classList.contains('cpf-mask')) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = v;
        }
    });

    // 2. LOADING NOS BOTÕES (CADASTRO E EDIÇÃO)
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.classList.contains('form-editar-usuario') || form.id === 'formUsuario') {
            if (form.checkValidity()) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const loadingBtn = form.querySelector('.btn-loading-edit') || form.querySelector('#btnLoadingUser');
                
                if (submitBtn && loadingBtn) {
                    submitBtn.style.setProperty('display', 'none', 'important');
                    loadingBtn.style.setProperty('display', 'inline-block', 'important');
                }
            }
        }
    });

    // 3. CONFIRMAÇÃO DE EXCLUSÃO (SWAL)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-delete-confirm')) {
            const btn = e.target.closest('.btn-delete-confirm');
            const form = btn.closest('form');
            Swal.fire({
                title: 'Excluir usuário?',
                text: "Esta ação é irreversível!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5c7c',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        }
    });

    // 4. FILTRO DE BUSCA
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.user-row').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }
});
</script>

@endsection