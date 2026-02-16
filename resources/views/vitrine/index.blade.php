@extends('vitrine.layout.app')

@section('content')

@include('vitrine._modals.agendar')

<style>
  section[id], div[id] {
    scroll-margin-top: 100px; /* Ajuste esse valor conforme a altura da sua Navbar */
}
html {
    scroll-behavior: smooth;
}

/* Garante que o link active tenha destaque visual */
.navbar-light .navbar-nav .nav-link.active {
    color: var(--bs-primary) !important;
    font-weight: bold;
}
</style>
<div class="container-fluid p-0 hero-header bg-light mb-5"  id="pagina-inicial">
    <div class="container p-0">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6 hero-header-text py-5">
                <div class="py-5 px-3 ps-lg-0">
                    <h1 class="font-dancing-script text-primary animated slideInLeft ">
                        Bem-vindo ao
                    </h1>
                    
                    <h1 class="display-1 mb-4 animated slideInLeft text-capitalize">
                        {{ $empresa->nome_fantasia ?? $empresa->razao_social }}
                    </h1>

                    <div class="row g-4 animated slideInLeft">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="btn-square btn btn-primary flex-shrink-0">
                                    <i class="fa fa-phone text-dark"></i>
                                </div>
                                <div class="px-3">
                                    <h5 class="text-primary mb-0">Telefone</h5>
                                    <p class="fs-5 text-dark mb-0">
                                        {{ $empresa->whatsapp }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-primary py-3 px-5" data-bs-toggle="modal" data-bs-target="#modalAgendamento">
                                    <i class="fa fa-calendar-alt me-2"></i> Agendar Agora
                                </button>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>

            <div class="col-lg-6">
    <div class="owl-carousel header-carousel animated fadeIn">
        @forelse($empresa->galeria->take(4) as $foto)
            {{-- <img class="img-fluid" src="{{ asset('storage/' . $foto->caminho) }}" style="height: 500px; object-fit: cover;"> --}}
            <img class="img-fluid" src="{{ asset('storage/' . $foto->caminho) }}">
        @empty
            {{-- Fallback caso o salão não tenha fotos cadastradas --}}
            <img class="img-fluid" src="{{ asset('vitrine/img/hero-slider-1.jpg') }}">
            <img class="img-fluid" src="{{ asset('vitrine/img/hero-slider-2.jpg') }}">
            <img class="img-fluid" src="{{ asset('vitrine/img/hero-slider-3.jpg') }}">
        @endforelse
    </div>
</div>
        </div>
    </div>
</div>



<!-- Service Start -->
    <div class="container-fluid service py-5" id="servicos">
    <div class="container">
        <div class="text-center wow fadeIn" data-wow-delay="0.1s">
            <h1 class="font-dancing-script text-primary">Nossos Serviços</h1>
            <h1 class="mb-5">Explore Nossas Especialidades</h1>
        </div>
        <div class="row g-4 text-center">
            @foreach($empresa->servicos as $servico)
                <div class="col-md-6 col-lg-4">
                    <div class="service-item h-100 p-4 border rounded shadow-sm wow fadeIn" data-wow-delay="0.1s">
                        <img class="img-fluid" src="storage/{{ $servico->image }}" alt="">
                        
                        <h3 class="mb-2">{{ $servico->nome }}</h3>
                        
                        

                        <p class="mb-3">
                            {{ $servico->descricao ?? 'Serviço de alta qualidade realizado por profissionais especializados.' }}
                        </p>

                        <button type="button" 
                                class="btn btn-sm btn-primary text-uppercase px-4 py-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalAgendamento"
                                onclick="selecionarServico('{{ $servico->id }}')">
                            Agendar <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
    <!-- Service End -->


    <!-- Pricing Start -->
    <div class="container-fluid price px-0 py-5" id="valores">
    <div class="row g-0">
        <div class="col-md-6">
            <div class="d-flex align-items-center h-100 bg-primary p-5">
                <div class="wow fadeIn" data-wow-delay="0.3s">
                    <h1 class="font-dancing-script text-white">Tabela de Preços</h1>
                    <h1 class="mb-0 text-white">{{ $empresa->razao_social }}</h1>
                    <h1 class="display-1 text-uppercase mb-5" style="letter-spacing: 10px; color: rgba(255,255,255,0.1);">Valores</h1>
                    <div class="row g-4 align-items-center">
                        
                        <div class="col-lg-6">
                            <p class="text-white">Confira nossos valores e reserve seu horário agora mesmo. Qualidade e bem-estar para você.</p>
                            <button class="btn btn-dark py-3 px-4" data-bs-toggle="modal" data-bs-target="#modalAgendamento">Agendar Agora</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="h-100 bg-dark p-5">
                @foreach($empresa->servicos as $servico)
    <div class="price-item mb-3 d-flex align-items-center justify-content-between wow fadeIn" data-wow-delay="{{ 0.1 * $loop->iteration }}s">
        
        <div class="flex-shrink-0" style="width: 80px; height: 80px;">
            @if($servico->image)
                {{-- Imagem do Banco de Dados --}}
                <img class="img-fluid rounded w-100 h-100" 
                     src="{{ asset('storage/' . $servico->image) }}" 
                     alt="{{ $servico->nome }}" 
                     style="object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
            @else
                {{-- Ícone Default quando não tiver imagem --}}
                <div class="rounded d-flex align-items-center justify-content-center bg-dark border border-secondary w-100 h-100">
                    <i class="mdi mdi-content-cut text-primary" style="font-size: 2rem;"></i>
                </div>
            @endif
        </div>
        
        <div class="text-end px-4 flex-grow-1 border-bottom border-secondary pb-2">
            <h6 class="text-uppercase text-primary mb-1">{{ $servico->nome }}</h6>
            <div class="d-flex justify-content-end align-items-baseline">
                <small class="text-muted me-3">
                    {{ $servico->descricao ? \Illuminate\Support\Str::limit($servico->descricao, 30) : $servico->duracao . ' min' }}
                </small>
                
                <h3 class="text-white font-work-sans mb-0">
                    R$ {{ number_format($servico->preco, 2, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
@endforeach
            </div>
        </div>
    </div>
</div>
    <!-- Pricing End -->


    <!-- Gallery Start -->
    @if($empresa->galeria->count() > 0)
    <div class="container-fluid gallery py-5" id="galeria">
        <div class="container">
            <div class="text-center wow fadeIn" data-wow-delay="0.2s">
                <h1 class="font-dancing-script text-primary">Galeria</h1>
                <h1 class="mb-5">Explore Nosso Trabalho</h1>
            </div>
            <div class="row g-0">
                @foreach($empresa->galeria->take(6) as $index => $foto)
                    @php
                        // Mantém o layout assimétrico do template
                        $colClass = ($index == 0 || $index == 5) ? 'col-md-6' : 'col-md-3';
                    @endphp
                    
                    <div class="{{ $colClass }} wow fadeIn" data-wow-delay="{{ 0.2 * ($index + 1) }}s">
                        <div class="gallery-item h-100">
                            <img src="{{ asset('storage/' . $foto->caminho) }}" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 300px;">
                            <div class="gallery-icon">
                                <a href="{{ asset('storage/' . $foto->caminho) }}" class="btn btn-primary btn-lg-square"
                                    data-lightbox="gallery-alcecar"><i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
    <!-- Gallery End -->


    <!-- Team Start -->
    @if(isset($empresa->profissionais) && $empresa->profissionais->count() > 0)
{{-- Adicionado overflow-hidden para evitar o scroll horizontal causado pelas margens negativas da row --}}
<div class="container-fluid gallery py-5 overflow-hidden" id="equipe">
    <div class="container py-4">
        <div class="text-center wow fadeIn" data-wow-delay="0.2s">
            <h1 class="font-dancing-script text-primary">Nossa Equipe</h1>
            <h1 class="mb-5">Especialistas à sua disposição</h1>
        </div>
        <div class="row g-4 team">
    @foreach($empresa->profissionais as $index => $func)
        <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="{{ 0.1 + ($index * 0.2) }}s">
            <div class="team-item position-relative overflow-hidden">
                <img class="img-fluid w-100" 
     src="{{ $func->foto ?? asset('vitrine/img/woman.png')}}" 
     alt="{{ $func->nome }}" 
     style="height: 350px; object-fit: cover;">
                
                <div class="team-overlay">
                    <p class="text-primary mb-1">{{ $func->especialidade ?? 'Profissional' }}</p>
                    <h4>{{ Str::title(explode(' ', trim($func->nome))[0]) }}</h4>
                    
                </div>
            </div>
        </div>
    @endforeach
</div>
    </div>
</div>
@endif
    <!-- Team End -->


    <!-- Testimonial Start -->
    {{-- O container só aparece se existirem depoimentos vinculados à empresa --}}
@if(isset($empresa->depoimentos) && $empresa->depoimentos->count() > 0)
<div class="container-fluid py-5">
    <div class="container">
        <div class="text-center wow fadeIn" data-wow-delay="0.2s">
            <h1 class="font-dancing-script text-primary">Depoimentos</h1>
            <h1 class="mb-5">O que nossas clientes dizem!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
            @foreach($empresa->depoimentos as $depoimento)
                <div class="text-center bg-light p-4">
                    <i class="fa fa-quote-left fa-3x mb-3 text-primary"></i>
                    <p>{{ $depoimento->texto }}</p>
                    
                    {{-- Foto da cliente ou avatar padrão --}}
                    <img class="img-fluid mx-auto border p-1 mb-3 rounded-circle" 
                         src="{{ $depoimento->foto ? asset('storage/' . $depoimento->foto) : asset('vitrine/img/testimonial-default.jpg') }}" 
                         alt="{{ $depoimento->nome }}" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                    
                    <h4 class="mb-1">{{ $depoimento->nome }}</h4>
                    <span>{{ $depoimento->profissao_cliente ?? 'Cliente' }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
    <!-- Testimonial End -->

    @if(session('agendamento_detalhes'))
<div class="modal fade" id="modalSucessoAgendamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success fa-5x" style="font-size: 80px;"></i>
                </div>
                <h3 class="fw-bold mb-3">Agendamento Confirmado!</h3>
                <p class="text-muted mb-4">Olá <strong>{{ session('agendamento_detalhes.nome') }}</strong>, seu horário foi reservado com sucesso no sistema Alcecar.</p>
                
                <div class="bg-light rounded-3 p-3 mb-4 text-start">
                    <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                        <span class="text-muted small">Serviço:</span>
                        <span class="fw-bold text-primary">{{ session('agendamento_detalhes.servico') }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <span class="text-muted small">Data e Hora:</span>
                        <span class="fw-bold">{{ session('agendamento_detalhes.data') }} às {{ session('agendamento_detalhes.hora') }}</span>
                    </div>
                </div>

                <p class="small text-muted mb-4">Te esperamos no horário combinado!</p>
                
                <button type="button" class="btn btn-success w-100 py-3 fw-bold shadow-sm" data-bs-dismiss="modal" style="border-radius: 15px;">
    Excelente!
</button>
            </div>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    $(document).ready(function() {
        // 1. MODAL DE SUCESSO (Abre automaticamente após agendar)
        if ($('#modalSucessoAgendamento').length > 0) {
            var modalSucesso = new bootstrap.Modal(document.getElementById('modalSucessoAgendamento'));
            modalSucesso.show();
        }

        // 2. LÓGICA DE SCROLLSPY (Marca o menu conforme rola a página)
        const sections = document.querySelectorAll("#pagina-inicial, #servicos, #valores, #equipe, #galeria");
        const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

        function makeActive() {
            let current = "";
            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                // Ajuste de 150px para detectar a seção antes de chegar no topo
                if (window.pageYOffset >= sectionTop - 150) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach((link) => {
                link.classList.remove("active");
                // Verifica se o href do link contém o ID da seção atual
                if (link.getAttribute("href").includes(current)) {
                    link.classList.add("active");
                }
            });
        }

        window.addEventListener("scroll", makeActive);
        makeActive(); // Executa ao carregar para marcar o 'Início'

        // 3. FUNÇÃO AUXILIAR PARA O MODAL (Selecionar serviço via botão da vitrine)
        window.selecionarServico = function(servicoId) {
            $('#servicos_select').val(servicoId).change();
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('agendamento_detalhes'))
            var myModal = new bootstrap.Modal(document.getElementById('modalSucessoAgendamento'), {
                keyboard: true,
                backdrop: true // ou 'static' se você quiser obrigar o usuário a clicar no botão
            });
            myModal.show();

            // Garantia extra: Limpar resíduos ao fechar
            var modalEl = document.getElementById('modalSucessoAgendamento');
            modalEl.addEventListener('hidden.bs.modal', function () {
                // Se o backdrop insistir em ficar, isso resolve definitivamente:
                document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '0';
            });
        @endif
    });
</script>
@endpush

    @endsection