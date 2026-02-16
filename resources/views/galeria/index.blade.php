@extends('layouts.app')

@section('title', 'Galeria da Vitrine')

@section('content')

@include('components.toast')

{{-- Modal de Upload de Foto --}}
@include('galeria._modals.cadastrar-foto')

{{-- Scripts de Alerta (Toast) --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true,
    });
    @if (session('success')) Toast.fire({ icon: 'success', title: '{{ session('success') }}' }); @endif
    @if (session('error')) Toast.fire({ icon: 'error', title: '{{ session('error') }}' }); @endif
});
</script>
@endif

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h3 class="page-title">Galeria de Fotos</h3>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-2"> 
        <div class="row align-items-center mb-4 p-2">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Fotos da Vitrine</h4>
                <p class="text-muted font-13 mb-0">Imagens que aparecem no seu salão.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    @php
    $userLogged = auth()->user();
    $empresa = $userLogged->empresa;
    
    // Limite fixo de fotos para todos os usuários do Alcecar
    $limitePermitido = 10;
    
    $totalCadastrado = $fotos->count();
    $limiteAtingido = $totalCadastrado >= $limitePermitido;
@endphp

{{-- Na parte do alerta de limite, você também pode simplificar o texto --}}
@if($limiteAtingido)
    <div class="alert alert-warning py-2 px-3 mb-0 font-13 shadow-sm border-warning d-flex align-items-center">
        <i class="mdi mdi-alert-circle-outline me-2 fs-16"></i>
        <div>
            <span>Você atingiu o limite máximo de <strong>{{ $limitePermitido }} fotos</strong> na sua vitrine.</span>
        </div>
    </div>
@else
    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCadastrarFoto">
        <i class="uil-plus me-1"></i> Adicionar Foto
    </button>
@endif
                </div>
            </div>
        </div>

        {{-- Grid de Fotos Estilizado --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 p-2">
            @forelse ($fotos as $foto)
            <div class="col photo-card">
                <div class="card h-100 border shadow-none rounded-3 overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $foto->caminho) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-dark opacity-75">#{{ $foto->ordem }}</span>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <p class="text-dark fw-semibold mb-1 text-truncate font-13">{{ $foto->legenda ?? 'Sem legenda' }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <form action="{{ route('galeria.destroy', $foto->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-confirm">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="col-12 text-center py-5">
                <div class="avatar-lg bg-light-lighten rounded-circle mx-auto">
                    <i class="uil uil-image-v text-muted font-24"></i>
                </div>
                <h5 class="mt-3">Nenhuma foto na galeria</h5>
                <p class="text-muted">Adicione fotos dos seus melhores trabalhos para atrair clientes.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Confirmação de Exclusão (Swal)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-delete-confirm')) {
            const btn = e.target.closest('.btn-delete-confirm');
            const form = btn.closest('form');
            Swal.fire({
                title: 'Remover esta foto?',
                text: "Ela deixará de aparecer na sua vitrine.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fa5c7c',
                confirmButtonText: 'Sim, remover',
                cancelButtonText: 'Cancelar'
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        }
    });
});
</script>

@endsection