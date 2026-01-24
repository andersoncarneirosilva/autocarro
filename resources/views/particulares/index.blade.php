@extends('particulares.layout.app')

@section('content')

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


    <section id="services" class="services section mt-5">

  <div class="container d-flex justify-content-between align-items-center mb-4 aos-init aos-animate" data-aos="fade-up">
    <div class="section-title mb-0" style="padding-bottom: 0;">
        <h2 style="margin-bottom: 0;">Meus</h2>
        <p style="margin-bottom: 0;">Anúncios</p>
    </div>

    <div>
        @php
    $limiteAtingido = $contagem >= 1;
@endphp

@if($limiteAtingido)
    <button class="btn btn-secondary d-flex align-items-center px-4 rounded-pill shadow-sm" 
            style="height: 45px; font-weight: 600; cursor: not-allowed;" 
            disabled 
            title="Limite de 2 anúncios atingido">
        <i class="bi bi-slash-circle me-2" style="font-size: 1.2rem;"></i>
        CRIAR NOVO ANÚNCIO
    </button>
@else
    <a href="{{ route('particulares.create') }}" 
       class="btn btn-primary d-flex align-items-center px-4 rounded-pill shadow-sm" 
       style="background: #ff4a17; border: none; height: 45px; font-weight: 600;">
        <i class="bi bi-plus-circle me-2" style="font-size: 1.2rem;"></i>
        CRIAR NOVO ANÚNCIO
    </a>
@endif

{{-- Opcional: Aviso visual abaixo do botão --}}
@if($limiteAtingido)
    <p class="text-danger mt-2 small"><i class="bi bi-info-circle"></i> Você atingiu o limite máximo de 1 anúncio para conta Particular.</p>
@endif
    </div>
</div>

  <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-5">

     @include('particulares.components.card-veiculos')

    </div>
  </div>

</section>
    
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete-confirm');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.form-delete');
            
            Swal.fire({
                title: 'Excluir Anúncio?',
                text: "Esta ação não poderá ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4a17',
                cancelButtonColor: '#313a46',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
    @endsection