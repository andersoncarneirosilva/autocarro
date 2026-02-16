@extends('layouts.app')

@section('title', 'Serviços')

@section('content')

@include('components.toast')

{{-- Modais de Serviços (Vamos criar em seguida) --}}
@include('servicos._modals.cad')
@include('servicos._modals.edit')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Serviços</li>
                </ol>
            </div>
            <h3 class="page-title">Serviços</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Catálogo de Serviços</h4>
                <p class="text-muted font-13 mb-0">Gerencie os preços e durações dos serviços do Alcecar.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('servicos.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-0">
                                    <i class="mdi mdi-magnify text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control bg-light border-0 ps-0" 
                                       placeholder="Buscar serviço..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalCadastrarServico">
                        <i class="mdi mdi-plus me-1"></i> Cadastrar
                    </button>
                </div>
            </div>
        </div>

        @if ($servicos->count() > 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0">
                <thead>
                    <tr class="bg-dark">
                        <th class="py-3 text-white fw-semibold border-0">Serviço</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Preço</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Duração</th>
                        <th class="py-3 text-white fw-semibold border-0 text-center">Status</th>
                        <th class="py-3 text-center text-white fw-semibold border-0">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicos as $serv)
                        <tr class="align-middle">
                            <td>
    <div class="d-flex align-items-center">
        {{-- Container da Imagem ou Ícone --}}
        <div class="me-3">
            @if($serv->image)
                <img src="{{ asset('storage/' . $serv->image) }}" 
                     alt="{{ $serv->nome }}" 
                     class="rounded-circle border shadow-sm" {{-- Alterado para rounded-circle --}}
                     style="width: 42px; height: 42px; object-fit: cover;">
            @else
                {{-- Div do ícone também alterada para rounded-circle --}}
                <div class="rounded-circle bg-primary-lighten d-flex align-items-center justify-content-center text-primary fw-bold border" 
                     style="width: 42px; height: 42px; font-size: 18px;">
                    <i class="mdi mdi-image-off-outline text-muted"></i>
                </div>
            @endif
        </div>

        {{-- Informações do Serviço --}}
        <div>
            <span class="fw-semibold text-dark d-block">{{ $serv->nome }}</span>
            <small class="text-muted">Cód: #{{ str_pad($serv->id, 4, '0', STR_PAD_LEFT) }}</small>
        </div>
    </div>
</td>
                            <td class="text-center">
                                <span class="fw-bold text-dark">R$ {{ number_format($serv->preco, 2, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-muted border">
                                    <i class="mdi mdi-clock-outline me-1"></i>{{ $serv->duracao }} min
                                </span>
                            </td>
                            <td class="text-center">
                                @if($serv->status ?? true)
                                    <span class="badge bg-success-lighten text-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger-lighten text-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" 
                                            class="btn-action edit btn-editar-servico" 
                                            data-id="{{ $serv->id }}"
                                            data-nome="{{ $serv->nome }}"
                                            data-preco="{{ number_format($serv->preco, 2, ',', '.') }}"
                                            data-image="{{ $serv->image }}"
                                            data-descricao="{{ $serv->descricao }}"
                                            data-duracao="{{ $serv->duracao }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    
                                    <form action="{{ route('servicos.destroy', $serv->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action delete border-0 btn-delete-confirm" data-nome="{{ $serv->nome }}" title="Excluir">
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
                <i class="mdi mdi-information-outline me-2"></i> Nenhum serviço cadastrado no Alcecar.
            </div>
        @endif
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lógica para Popular o Modal de Edição de Serviço
    const botoesEditar = document.querySelectorAll('.btn-editar-servico');
    const modalEditElement = document.getElementById('modalEditarServico');
    
    if (modalEditElement) {
        const modalEdit = new bootstrap.Modal(modalEditElement);

        botoesEditar.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nome = this.getAttribute('data-nome');
                const preco = this.getAttribute('data-preco'); // Já deve vir com vírgula (ex: 150,00)
                const duracao = this.getAttribute('data-duracao');
                const imagem = $(this).data('image');
                const descricao = this.getAttribute('data-descricao') || '';

                // Preenche o Action do Form
                document.getElementById('edit_servico_form').action = `/servicos/${id}`;
                
                // Preenche os Inputs
                document.getElementById('edit_servico_nome').value = nome;
                document.getElementById('edit_servico_preco').value = preco;
                document.getElementById('edit_servico_duracao').value = duracao;
                document.getElementById('edit_servico_descricao').value = descricao;

                // Reaplica a máscara de dinheiro após preencher o valor
                $('.money').mask('#.##0,00', {reverse: true});

                // Lógica da Imagem
                if (imagem) {
                    // Se a imagem existir no banco, aponta para o storage
                    $('#edit_preview_foto_servico').attr('src', `/storage/${imagem}`);
                } else {
                    // Se não tiver imagem, volta para o placeholder
                    $('#edit_preview_foto_servico').attr('src', '{{ asset("assets/images/placeholder-service.png") }}');
                }
                
                            modalEdit.show();
                        });
                    });
                }

    // Reaproveita o SweetAlert de Exclusão que já fizemos
    document.querySelectorAll('.btn-delete-confirm').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const nome = this.getAttribute('data-nome');

            Swal.fire({
                title: 'Excluir ' + nome + '?',
                text: "Isso pode afetar históricos de agendamentos.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>


@endsection