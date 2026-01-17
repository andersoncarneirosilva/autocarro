<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Alcecar | Sua loja de Veículo</title>
  
  <meta name="description" content="Compre online com praticidade e segurança. Uma loja virtual completa com produtos selecionados, ofertas exclusivas e entrega rápida.">
  <meta name="keywords" content="loja virtual, ecommerce, compras online, produtos online, ofertas, loja online">
  <meta name="author" content="Alcecar">
  <meta name="robots" content="index, follow">

  <meta property="og:type" content="website">
  <meta property="og:url" content="https://alcecar.com.br/">
  <meta property="og:title" content="Loja Virtual | Compre Online com Facilidade">
  <meta property="og:description" content="Descubra uma nova forma de comprar online. Produtos de qualidade, navegação simples e pagamento seguro em um só lugar.">
  <meta property="og:image" content="{{ url('layout/images/logo_carro.png') }}">

  <meta property="twitter:card" content="summary_large_image"> 
  <meta property="twitter:url" content="https://alcecar.com.br/">
  <meta property="twitter:title" content="Loja Virtual | Sua Melhor Experiência de Compra Online">
  <meta property="twitter:description" content="Tudo o que você procura em uma loja online moderna, segura e feita para facilitar seu dia a dia.">
  <meta property="twitter:image" content="{{ url('layout/images/logo_carro.png') }}">


  <!-- Favicons -->
  <link href="{{ url('img/favicon.png') }}" rel="icon">
  <link href="{{ url('img/apple-touch-icon.png') }}" rel="apple-touch-icon">
<script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('assets/site_alcecar/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('assets/site_alcecar/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ url('assets/site_alcecar/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ url('assets/site_alcecar/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ url('assets/site_alcecar/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ url('assets/site_alcecar/css/main.css') }}" rel="stylesheet">

  <style></style>
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
  <script src="{{ url('assets/site_alcecar/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('assets/site_alcecar/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ url('assets/site_alcecar/vendor/aos/aos.js') }}"></script>
  <script src="{{ url('assets/site_alcecar/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ url('assets/site_alcecar/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ url('assets/site_alcecar/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ url('assets/site_alcecar/js/main.js') }}"></script>

</body>

</html>