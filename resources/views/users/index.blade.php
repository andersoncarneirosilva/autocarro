@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

@include('users._partials.cadastrar-usuario')

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
                    <li class="breadcrumb-item active">Usuários</li>
                </ol>
            </div>
            <h3 class="page-title">Usuários</h3>
        </div>
    </div>
</div>

<style>
/* Container que envolve a tabela */
.table-responsive-custom {
    max-height: 500px; /* Defina a altura máxima que desejar */
    overflow-y: auto;  /* Scroll vertical */
    overflow-x: auto;  /* Scroll horizontal para mobile */
    border: 1px solid #dee2e6;
    border-radius: 8px;
}

/* Deixa o cabeçalho da tabela fixo no topo enquanto você rola */
.table-responsive-custom thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #343a40 !important; /* Cor de fundo do cabeçalho */
}

/* Estilização da barra de rolagem para ficar mais elegante */
.table-responsive-custom::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.table-responsive-custom::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}
.table-responsive-custom::-webkit-scrollbar-track {
    background: #f1f1f1;
}
</style>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4"> <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Usuários Cadastrados</h4>
                <p class="text-muted font-13 mb-0">Gerencie permissões e dados dos usuários.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="uil uil-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control bg-light border-0 ps-0" 
                                   placeholder="Filtrar por nome, email ou telefone...">
                        </div>
                    </div>

                    @can('access-admin') 
                        <button type="button" class="btn btn-primary btn-sm rounded-pill shadow-sm px-3" 
                                data-bs-toggle="modal" data-bs-target="#modalCadastrarUsuario">
                            <i class="uil uil-plus me-1"></i> Novo Usuário
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0" id="userTable">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Usuário</th>
                        <th class="py-3 text-white fw-semibold border-0">Telefone</th>
                        <th class="py-3 text-white fw-semibold border-0">Acesso</th>
                        <th class="py-3 text-white fw-semibold border-0">Status</th>
                        <th class="py-3 text-white fw-semibold border-0">Último acesso</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @forelse ($users as $user)
                    <tr class="align-middle user-row">
                        <td class="table-user">
                            <div class="d-flex align-items-center">
    @if($user->image)
        <img src="{{ url("storage/{$user->image}") }}" 
             class="rounded-circle me-3 border shadow-sm" 
             style="width: 38px; height: 38px; object-fit: cover;">
    @else
        <div class="rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm border text-white fw-bold" 
             style="width: 38px; height: 38px; background-color: #727cf5; font-size: 16px;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    @endif
    
    <div>
        <span class="d-block fw-semibold text-dark user-name">{{ $user->name }}</span>
        <small class="text-muted user-email">{{ $user->email }}</small>
    </div>
</div>
                        </td>
                        <td>
                            <?php 
                        $fone = $user->telefone;
                        // Formatar o telefone
                        $fone_formatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2.$3', $fone);
                        // Gerar o link com o número sem formatação
                        $link_whatsapp = "https://wa.me/+55" . preg_replace('/\D/', '', $fone); 
                        ?>
                        <a href="<?= $link_whatsapp ?>" target="_blank" style="color: #0b8638;">
                                        <i class="uil uil-whatsapp"></i> <?= $fone_formatado ?>
                                    </a></td>
                        <td>
                            <span class="badge {{ $user->nivel_acesso == 'Administrador' ? 'badge-outline-danger text-danger' : 'badge-outline-info text-info' }} rounded-pill px-2">
                                {{ ucfirst($user->nivel_acesso) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClass = str_contains($user->classe, 'success') || $user->status == 'Ativo' ? 'success' : 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusClass }}-lighten text-{{ $statusClass }} border border-{{ $statusClass }} px-2 rounded-pill">
                                <i class="mdi mdi-circle me-1 small"></i>{{ $user->status }}
                            </span>
                        </td>
                        <td>
    @if($user->last_login_at)
        <span class="text-nowrap">
            <i class="mdi mdi-clock-outline me-1 text-muted"></i> 
            {{ $user->last_login_at->format('d/m/Y H:i') }}
        </span>
    @else
        Nunca acessou
    @endif
</td>
                        <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <button type="button" 
                class="btn-action edit" 
                data-bs-toggle="modal" 
                data-bs-target="#modalEditarUsuario{{ $user->id }}" 
                title="Editar Usuário">
            <i class="uil uil-pen"></i>
        </button>
        
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline form-delete">
            @csrf
            @method('DELETE')
            <button type="button" 
                    class="btn-action delete btn-delete" 
                    title="Excluir Usuário">
                <i class="mdi mdi-delete"></i>
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @include('users._partials.editar-usuario') 
                    @empty
                    <tr id="no-results" style="display: none;">
                        <td colspan="6" class="text-center py-5 text-muted">Nenhum usuário encontrado.</td>
                    </tr>
                    @endforelse
                    <tr id="no-results-found" style="display: none;">
        <td colspan="6" class="text-center py-5">
            <div class="text-center">
                <i class="uil uil-search-alt text-muted h1"></i>
                <h5 class="text-muted mt-2">Nenhum usuário corresponde à sua pesquisa</h5>
                <p class="text-muted small">Verifique a ortografia ou tente termos diferentes.</p>
            </div>
        </td>
    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('.user-row');
    const noResultsRow = document.getElementById('no-results-found');

    if (!searchInput) return; // Segurança caso o input não exista na página

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;

        tableRows.forEach(row => {
            // Selecionamos os elementos com segurança usando opcional chaining ou check
            const nameEl = row.querySelector('.user-name');
            const emailEl = row.querySelector('.user-email');
            const phoneEl = row.querySelector('.user-phone');

            // Extraímos o texto apenas se o elemento existir, senão usamos string vazia
            const name = nameEl ? nameEl.textContent.toLowerCase() : '';
            const email = emailEl ? emailEl.textContent.toLowerCase() : '';
            const phone = phoneEl ? phoneEl.textContent.toLowerCase() : '';

            // Lógica de filtro
            if (name.includes(searchTerm) || 
                email.includes(searchTerm) || 
                phone.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mostra ou esconde a linha de "Nenhum usuário encontrado"
        if (noResultsRow) {
            noResultsRow.style.display = (visibleCount === 0 && searchTerm !== "") ? '' : 'none';
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Captura todos os botões de excluir
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Impede o envio imediato do form

            const form = this.closest('form'); // Pega o formulário pai

            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não poderá ser revertida!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5c7c', // Cor de perigo (danger)
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                background: '#fff', // Se quiser dark, mude para #1a1d21
                color: '#313a46'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Envia o formulário se confirmado
                }
            });
        });
    });
});
</script>

@endsection