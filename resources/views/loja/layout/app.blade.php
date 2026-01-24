<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'Alcecar | Referência em Compra e Venda de Veículos')</title>

  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('title', 'Alcecar | A busca inteligente para seu novo veículo')">
  <meta property="og:description" content="@yield('description', 'Milhares de ofertas de carros, motos e utilitários no Alcecar.')">
  <meta property="og:image" content="@yield('image', url('frontend/images/logo_alcecar.png'))">

  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ url()->current() }}">
  <meta property="twitter:title" content="@yield('title', 'Alcecar | Encontre seu carro ou moto ideal')">
  <meta property="twitter:description" content="@yield('description', 'O Alcecar facilita sua busca por veículos novos e usados.')">
  <meta property="twitter:image" content="@yield('image', url('frontend/images/logo_alcecar.png'))">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="{{ url('frontend/images/favicon/favicon.ico') }}" rel="icon">
  <link href="{{ url('frontend/images/favicon/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
  <link href="{{ url('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ url('frontend/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ url('frontend/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ url('frontend/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ url('frontend/css/main.css') }}" rel="stylesheet">

  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-02FMMXT79W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-02FMMXT79W');
</script>

<style>
  /* 1. CONTAINER E FLEXIBILIDADE */
  .search-container-custom {
    background: #fff;
    border-radius: 10px !important;
    padding: 10px 15px !important;
    box-shadow: 0 10px 35px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 1100px;
  }

  .search-flex-container {
    display: flex !important;
    flex-direction: row !important;
    align-items: center;
    gap: 10px;
  }

  .custom-field {
    flex: 2;
    position: relative;
    min-width: 200px;
  }
  .custom-field:first-child { flex: 3; }

  .select-trigger {
    width: 100%;
    height: 55px;
    background-color: #f6f6f6 !important;
    border: none !important;
    border-radius: 12px !important;
    padding: 0 15px !important;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 15px;
    color: #333;
    transition: 0.2s;
  }

  /* 2. CAIXA DE RESULTADOS E SETAS (Efeito solicitado) */
  .custom-result-box-wrapper {
    width: 100%;
    border: none !important;
    border-radius: 15px !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    margin-top: 10px !important;
    background: #fff !important;
    z-index: 1000;
    overflow: hidden; /* Corta o conteúdo para as setas funcionarem */
    padding: 0 !important;
  }

  .custom-result-box {
    max-height: 250px !important; 
    overflow-y: auto !important; /* Permite o scroll */
    padding: 8px !important;
    margin: 0;
    list-style: none;
    
    /* Esconde a barra de scroll padrão para manter o design (opcional) */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE/Edge */
}

/* Esconde a barra no Chrome/Safari/Brave */
.custom-result-box::-webkit-scrollbar {
    display: none;
}

  /* Estilo das Setas de Navegação */
  .scroll-arrow {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fff;
    height: 25px;
    cursor: pointer;
    font-size: 12px;
    transition: 0.2s;
    user-select: none;
  }
  .scroll-arrow:hover { background: #f8f8f8; color: #ff4a17; }
  .scroll-arrow.up { border-bottom: 1px solid #eee; }
  .scroll-arrow.down { border-top: 1px solid #eee; }

  .dropdown-item {
    border-radius: 8px !important;
    padding: 10px 15px !important;
    font-size: 14px !important;
    font-weight: 500;
    width: 100%;
    text-align: left;
    border: none;
    background: none;
  }
  .dropdown-item:hover { background-color: #f0f0f0 !important; color: #ff4a17 !important; }

  .btn-search-purple {
    background-color: #ff4a17 !important;
    color: #fff !important;
    border: none !important;
    border-radius: 15px !important;
    height: 55px;
    padding: 0 30px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
  }

  /* Mobile */
  @media (max-width: 991px) {
    .search-flex-container { flex-direction: column !important; }
    .custom-field, .btn-search-purple { width: 100%; }
  }


</style>


<style>


/* 3. Estilo do Card (Branco com Sombra) */
.category-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 35px 15px;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1); /* Sombra suave para destacar do fundo */
  transition: all 0.3s ease;
  height: 100%;
  border: 1px solid transparent;
  cursor: pointer;
}

.category-card:hover {
  transform: translateY(-10px);
  border-color: #ff4a17;
}

/* 4. Ícones e Títulos */
.category-card .icon-box {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 80px;  /* Ajuste conforme seu design */
  height: 80px; /* Ajuste conforme seu design */
  margin: 0 auto 15px;
  overflow: hidden;
}

.category-card .icon-box img {
  width: 100%;
  height: auto;
  max-width: 60px; /* Controla o tamanho real da imagem do carro */
  object-fit: contain;
  transition: transform 0.3s ease;
}

/* Efeito de zoom ao passar o mouse no card */
.category-card:hover .icon-box img {
  transform: scale(1.1);
}

/* Ajustes para Celular */
@media (max-width: 991px) {
  .categories-overlap {
    margin-top: -80px;
  }
  .category-card {
    padding: 20px 10px;
  }
  .category-card .icon-box {
    font-size: 30px;
  }
}


</style>

{{-- ESTILO PARA O FILTRO --}}
<style>
  .accordion-button:not(.collapsed) { background-color: transparent; color: inherit; box-shadow: none; }
  .accordion-button::after { background-size: 1rem; }
  .brand-item:hover { background-color: #f8f9fa; border-color: var(--accent-color) !important; color: var(--accent-color); }
  .cursor-pointer { cursor: pointer; }
</style>
<style>
  /* Estilização Geral do Card */
.course-item {
    background: #fff;
    border-radius: 15px;
    border: 1px solid #eee;
    overflow: hidden;
    transition: all 0.3s ease;
}

.course-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Mini Cards de Info dentro do Card de Listagem */
.card-spec-grid {
    display: flex;
    gap: 8px;
    margin-bottom: 15px;
}

.mini-spec-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 6px 10px;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px solid #f0f0f0;
}

.mini-spec-card i {
    color: #ff4a17;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.mini-spec-card span {
    font-size: 0.7rem;
    font-weight: 700;
    color: #444;
    text-transform: uppercase;
}

/* Badge de Preço e Categoria */
.category-badge {
    background: #fff0eb;
    color: #ff4a17;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
    text-transform: uppercase;
}

/* Container de Filtros */
.active-filters {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
}

/* Estilo das Etiquetas (Pills) */
.filter-pill {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 50px;
    padding: 6px 14px;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.filter-pill:hover {
    border-color: #ff4a17;
    background: #fffafa;
}

.filter-pill strong {
    color: #333;
}

.filter-pill .remove-filter {
    color: #adb5bd;
    display: flex;
    align-items: center;
    transition: color 0.2s;
}

.filter-pill:hover .remove-filter {
    color: #ff4a17;
}

/* Link de Limpar Tudo */
.btn-clear-all {
    font-size: 0.8rem;
    color: #ff4a17;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    padding: 5px 10px;
}

.btn-clear-all:hover {
    color: #d43d12;
    text-decoration: underline;
}

.btn-filter-year {
    border: 1px solid #dee2e6;
    color: #666;
    background: #fff;
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 5px;
    transition: all 0.2s;
}
.btn-filter-year:hover, .btn-filter-year.active {
    background-color: #ff4a17;
    border-color: #ff4a17;
    color: #fff;
}
</style>

</head>

<body class="index-page">

  @include('loja.components.header')

  <main class="main">

   @yield('content')
   
  </main>

  @include('loja.components.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
   
<script src="{{ url('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('frontend/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ url('frontend/vendor/aos/aos.js') }}"></script>
<script src="{{ url('frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ url('frontend/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ url('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ url('frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ url('frontend/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

<script src="{{ url('frontend/js/main.js') }}"></script>

</body>

</html>