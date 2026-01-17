<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Autocar</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ url('img/favicon.png') }}" rel="icon">
  <link href="{{ url('img/apple-touch-icon.png') }}" rel="apple-touch-icon">
<script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('site/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('site/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ url('site/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ url('site/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ url('site/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ url('site/css/main.css') }}" rel="stylesheet">
<style>
.heading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45); /* ajuste aqui (0.35 a 0.6) */
    z-index: 1;
}

.page-title .container {
    position: relative;
    z-index: 2;
}

</style>
</head>

<body class="starter-page-page">

  @include('site.components.header')

  <main class="main">

    <div class="page-title" style=" min-height: 320px; background-image: url('{{ $veiculo->background_image }}'); background-size: cover; background-position: center;
        position: relative;" data-aos="fade">
    <div class="heading">
    
    <div class="heading-overlay"></div>

    <div class="container position-relative">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 text-white">
                <h1>{{ $veiculo->marca_exibicao }}</h1>
                <p>{{ $veiculo->modelo_exibicao }}</p>
            </div>
        </div>
    </div>
</div>




  <nav class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="{{ route('site.index') }}">Página Inicial</a></li>
        <li><a href="#">Estoque</a></li>
        <li class="current">{{ $veiculo->modelo_exibicao }}</li>
      </ol>
    </div>
  </nav>
</div>

{{-- {{ $veiculo->background_image }} --}}

<section class="container py-5 mt-5">
    
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $veiculo->marca_exibicao }}</h2>
        <p>{{ $veiculo->modelo_exibicao }}<br></p>
    </div>


    <div class="row">
    <div class="col-lg-7">
        <div class="row g-2">
            <div class="{{ count($veiculo->images) > 1 ? 'col-lg-10 col-12' : 'col-12' }}">
                <div id="carouselDetalhes" class="carousel slide shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($veiculo->images as $index => $img)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}" class="d-block w-100" style="height: 450px; object-fit: cover;" alt="{{ $veiculo->marca }}">
                            </div>
                        @endforeach
                    </div>
                    
                    @if(count($veiculo->images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetalhes" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselDetalhes" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            </div>

            @if(count($veiculo->images) > 1)
                <div class="col-2 d-none d-lg-block">
                    <div class="d-flex flex-column gap-2 overflow-auto" style="max-height: 450px; scrollbar-width: thin;">
                        @foreach($veiculo->images as $index => $img)
                            <img src="{{ asset('storage/' . $img) }}" 
                                 class="img-thumbnail border-0 p-0 shadow-sm" 
                                 style="height: 85px; width: 100%; object-fit: cover; cursor: pointer; transition: 0.3s;" 
                                 onclick="bootstrap.Carousel.getInstance(document.getElementById('carouselDetalhes')).to({{ $index }})"
                                 onmouseover="this.style.filter='brightness(1.2)'"
                                 onmouseout="this.style.filter='brightness(1)'"
                                 alt="Miniatura {{ $index + 1 }}">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-5">
        <div class="p-4 bg-white shadow-sm rounded h-100 border">
            <h1 class="h3 fw-bold text-uppercase mb-1">{{ $veiculo->marca_exibicao }} - {{ $veiculo->modelo_exibicao }}</h1>
            <p class="text-secondary mb-4">{{ $veiculo->ano }} | {{ number_format($veiculo->kilometragem, 0, ',', '.') }} km | {{ $veiculo->cambio }}</p>
            
            <hr>

            <div class="price-box my-4">
                @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
                    <small class="text-muted text-decoration-line-through d-block">De: R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</small>
                    <h2 class="text-success fw-bold">Por: R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}</h2>
                @else
                    <h2 class="text-dark fw-bold">R$ {{ number_format($veiculo->valor, 2, ',', '.') }}</h2>
                @endif
            </div>

            <div class="d-grid gap-2 mb-4">
                <a href="https://wa.me/5554997007847?text=Olá, tenho interesse no {{ $veiculo->marca }} {{ $veiculo->ano }}" 
                   target="_blank" class="btn btn-success btn-lg py-3 fw-bold shadow-sm">
                    <i class="bi bi-whatsapp"></i> ENTRAR EM CONTATO
                </a>
            </div>
        </div>
    </div>
</div>

    <div class="mt-4 p-4 bg-white shadow-sm rounded border">
        <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-2 text-red">Ficha Técnica</h5>
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-speedometer2 fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Kilometragem</small><span class="fw-bold">{{ number_format($veiculo->kilometragem, 0, ',', '.') }} km</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar3 fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Ano/Modelo</small><span class="fw-bold">{{ $veiculo->ano }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-card-text fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Final da Placa</small><span class="fw-bold">{{ substr($veiculo->placa, -1) }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-door-closed fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Nº Portas</small><span class="fw-bold">{{ $veiculo->portas }} Portas</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-fuel-pump fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Combustível</small><span class="fw-bold text-capitalize">{{ strtolower($veiculo->combustivel) }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-palette fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Cor</small><span class="fw-bold text-capitalize">{{ strtolower($veiculo->cor) }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-gear-wide-connected fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Câmbio</small><span class="fw-bold">{{ $veiculo->cambio }}</span></div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <i class="bi bi-car-front fs-3 text-red me-3"></i>
                    <div><small class="text-muted d-block">Carroceria</small><span class="fw-bold text-capitalize">{{ strtolower($veiculo->tipo) }}</span></div>
                </div>
            </div>
        </div>
    </div>

    @php 
        $adicionais = is_array($veiculo->adicionais) ? $veiculo->adicionais : json_decode($veiculo->adicionais, true);
        if(is_string($adicionais)) $adicionais = json_decode($adicionais, true);
    @endphp
    @if(!empty($adicionais))
    <div class="mt-4 p-4 bg-white shadow-sm rounded border-start border-primary border-4">
        <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-info-square fs-6"></i> Adicionais</h5>
        <div class="row">
            @foreach($adicionais as $item)
                <div class="col-md-3 col-6 mb-2">
                    <i class="bi bi-dot text-red fs-6"></i> {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @php 
        $opcionais = is_array($veiculo->opcionais) ? $veiculo->opcionais : json_decode($veiculo->opcionais, true);
        if(is_string($opcionais)) $opcionais = json_decode($opcionais, true);
    @endphp
    @if(!empty($opcionais))
    <div class="mt-4 p-4 bg-white shadow-sm rounded border-start border-success border-4">
        <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-plus-circle fs-6"></i> Opcionais e Equipamentos</h5>
        <div class="row">
            @foreach($opcionais as $item)
                <div class="col-md-3 col-6 mb-2">
                    <i class="bi bi-dot text-red fs-6"></i> {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @php 
        $modificacoes = is_array($veiculo->modificacoes) ? $veiculo->modificacoes : json_decode($veiculo->modificacoes, true);
        if(is_string($modificacoes)) $modificacoes = json_decode($modificacoes, true);
    @endphp
    @if(!empty($modificacoes))
    <div class="mt-4 p-4 bg-white shadow-sm rounded border-start border-danger border-4">
        <h5 class="fw-bold mb-3 text-secondary">
    <i class="bi bi-tools fs-6"></i> Modificações / Upgrades
</h5>
        <div class="row">
            @foreach($modificacoes as $item)
                <div class="col-md-3 col-6 mb-2">
                    <i class="bi bi-dot text-red fs-6"></i> {{ $item }}
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="mt-4 p-4 bg-white shadow-sm rounded border">
        <h4 class="fw-bold border-bottom pb-2">Descrição Detalhada</h4>
        <p class="text-muted mt-3" style="white-space: pre-line; line-height: 1.8;">
            {{ $veiculo->observacoes ?? $veiculo->descricao ?? 'Nenhuma informação adicional fornecida.' }}
        </p>
    </div>

</section>

  </main>

  @include('site.components.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ url('site/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('site/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ url('site/vendor/aos/aos.js') }}"></script>
  <script src="{{ url('site/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ url('site/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ url('site/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ url('site/js/main.js') }}"></script>

</body>

</html>