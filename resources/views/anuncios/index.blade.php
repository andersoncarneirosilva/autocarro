@extends('layouts.app')

@section('title', 'Anuncios')

@section('content')

@include('anuncios._partials.cadastro-rapido')

{{-- Toasts de sessão --}}
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
                    <li class="breadcrumb-item active">Anúncios</li>
                </ol>
            </div>
            <h3 class="page-title">Anúncios</h3>
        </div>
    </div>
</div>




<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Anúncios cadastrados</h4>
                    <div class="dropdown btn-group">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Cadastrar
                                </button>
                                <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#cadastro-rapido"
                                        class="dropdown-item">
                                        Cadastro rápido
                                    </a>
                                    <a href="{{ route('veiculos.create-proc-manual') }}" class="dropdown-item">
                                        Cadastro manual
                                    </a>
                                </div>
                            </div>
                </div>
                
                @if ($veiculos->total() != 0)
                <div class="table-custom-container">
                    <table class="table table-custom table-nowrap table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Placa</th>
                                <th>Marca/Modelo</th>
                                <th>Ano/Modelo</th>
                                <th>Cor</th>
                                <th>KM</th>
                                <th>Câmbio</th>
                                <th>Portas</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($veiculos as $veiculo)
                            <tr>
                               <td class="d-flex align-items-center">
                                @php
                                    // Decodifica o JSON de imagens e pega a primeira
                                    $imagens = json_decode($veiculo->images);
                                    $primeiraImagem = !empty($imagens) ? $imagens[0] : null;
                                    
                                    // Pega a primeira letra da placa para o avatar reserva
                                    $inicialPlaca = substr($veiculo->placa, 0, 1);
                                @endphp

                                <div class="me-3">
                                    @if($primeiraImagem)
                                    <a href="{{ route('anuncios.show', $veiculo->id) }}" class="dropdown-item">
                                        <img src="{{ asset('storage/' . $primeiraImagem) }}" 
                                            alt="Veículo" 
                                            class="rounded-circle" 
                                            style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #dee2e6;">
                                    </a>
                                    @else
                                    <a href="{{ route('anuncios.show', $veiculo->id) }}" class="dropdown-item">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" 
                                            style="width: 40px; height: 40px; font-weight: bold; font-size: 1.2rem; text-transform: uppercase;">
                                            {{ $inicialPlaca }}
                                        </div>
                                    </a>
                                    @endif
                                </div>

                                <div>
                                    <span class="fw-bold d-block">{{ $veiculo->placa }}</span>
                                    <small class="text-muted">{{ $veiculo->tipo }}</small>
                                </div>
                            </td>  
                            <td>{{ $veiculo->marca_real }}/{{ $veiculo->modelo_real }}</td>
                            <td>{{ $veiculo->ano }}</td>
                            <td>{{ $veiculo->cor }}</td>
                            <td>{{ $veiculo->kilometragem ?? 'Não consta' }}</td>
                            <td>{{ $veiculo->cambio ?? 'Não consta' }}</td>
                            <td>
    @if($veiculo->status_anuncio == 'Publicado')
        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Publicado</span>
    @elseif($veiculo->status_anuncio == 'Aguardando' || $veiculo->status_anuncio == 'Espera')
        <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Em Espera</span>
    @elseif($veiculo->status_anuncio == 'Vendido')
        <span class="badge bg-info text-white"><i class="bi bi-cart-check me-1"></i> Vendido</span>
    @elseif($veiculo->status_anuncio == 'Inativo')
        <span class="badge bg-danger"><i class="bi bi-x-octagon me-1"></i> Inativo</span>
    @else
        <span class="badge bg-secondary">{{ $veiculo->status_anuncio ?? 'Não consta' }}</span>
    @endif
</td>


                                <td class="table-action position-relative">
                                                <div class="dropdown btn-group">
                                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" data-bs-boundary="viewport"
                                                        aria-expanded="false">
                                                        Ações
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-animated dropdown-menu-end">

                                                        <a href="{{ route('anuncios.show', $veiculo->id) }}"
                                                            class="dropdown-item">Ver/Editar</a>

                                                        <!-- Formulário Oculto para Arquivar -->
                                                        <form action="{{ route('anuncios.arquivar', $veiculo->id) }}"
                                                            method="POST" style="display: none;"
                                                            id="form-arquivar-{{ $veiculo->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>

                                                        <!-- Link para Arquivar com SweetAlert -->
                                                        <a href="#" onclick="confirmArchive({{ $veiculo->id }});"
                                                            class="dropdown-item">
                                                            Arquivar
                                                        </a>

                                                        <!-- Link que dispara o SweetAlert -->
                                                        <a href="#" onclick="confirmDelete({{ $veiculo->id }})" class="dropdown-item text-danger">
                                                            Excluir
                                                        </a>

                                                        <!-- Formulário invisível para enviar a exclusão -->
                                                        <form id="form-delete-{{ $veiculo->id }}" action="{{ route('anuncios.destroy', $veiculo->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @elseif($veiculos->total() == 0)
                        <div class="alert alert-warning bg-transparent text-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>

<script>
    function confirmArchive(id) {
        Swal.fire({
            title: "Arquivar Veículo",
            text: "Tem certeza que deseja arquivar este veículo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim, arquivar!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-arquivar-' + id).submit();
            }
        });
    }
</script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: "Excluir Veículo",
        text: "Essa ação não pode ser desfeita. Deseja continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete-' + id).submit();
        }
    });
}
</script>

@endsection