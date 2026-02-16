<div class="container-fluid bg-light sticky-top p-0">
    <nav class="navbar navbar-expand-lg navbar-light p-0">
        <a href="{{ route('vitrine.salao', $empresa->slug) }}" class="navbar-brand bg-primary py-4 px-5 me-0">
            <h3 class="mb-0 text-capitalize text-truncate" style="max-width: 250px;">
    <i class="bi bi-scissors me-1"></i>{{ $empresa->razao_social }}
</h3>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse p-3" id="navbarCollapse">
            <div class="navbar-nav mx-auto">
                <a href="#pagina-inicial" class="nav-item nav-link active">Início</a>
                <a href="#servicos" class="nav-item nav-link">Serviços</a>
                <a href="#valores" class="nav-item nav-link">Valores</a>
                <a href="#equipe" class="nav-item nav-link">Equipe</a>
            </div>
            <div class="d-flex">
    {{-- Facebook --}}
    @if(!empty($empresa->configuracoes['redes']['facebook']))
        <a class="btn btn-primary btn-sm-square me-3" href="{{ $empresa->configuracoes['redes']['facebook'] }}" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
    @endif

    {{-- Instagram --}}
    @if(!empty($empresa->configuracoes['redes']['instagram']))
        <a class="btn btn-primary btn-sm-square me-3" href="{{ $empresa->configuracoes['redes']['instagram'] }}" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
    @endif

    {{-- X (Twitter) --}}
    @if(!empty($empresa->configuracoes['redes']['twitter']))
        <a class="btn btn-primary btn-sm-square me-3" href="{{ $empresa->configuracoes['redes']['twitter'] }}" target="_blank">
            <i class="fab fa-twitter"></i>
        </a>
    @endif

    {{-- WhatsApp --}}
    @if($empresa->whatsapp)
        <a class="btn btn-primary btn-sm-square" href="https://wa.me/{{ preg_replace('/\D/', '', $empresa->whatsapp) }}" target="_blank">
            <i class="fab fa-whatsapp"></i>
        </a>
    @endif
</div>
        </div>
    </nav>
</div>

