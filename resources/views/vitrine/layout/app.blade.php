<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'Salone - Beauty Salon Website Template')</title>

  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('title', 'Alcecar | A busca inteligente para seu novo veículo')">
  <meta property="og:description" content="@yield('description', 'Milhares de ofertas de carros, motos e utilitários no Alcecar.')">
  <meta property="og:image" content="@yield('image')">

  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ url()->current() }}">
  <meta property="twitter:title" content="@yield('title', 'Alcecar | Encontre seu carro ou moto ideal')">
  <meta property="twitter:description" content="@yield('description', 'O Alcecar facilita sua busca por veículos novos e usados.')">
  <meta property="twitter:image" content="@yield('image', url('frontend/images/logo_alcecar.png'))">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&display=swap" rel="stylesheet">
  <link href="{{ url('frontend/images/favicon/favicon.ico') }}" rel="icon">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ url('vitrine/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ url('vitrine/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('vitrine/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('vitrine/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ url('vitrine/css/style.css') }}" rel="stylesheet">



</head>

<body>

  {{-- <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}

  @include('vitrine.components.navbar')

 

  @yield('content')
   


  @include('vitrine.components.footer')

  <!-- Scroll Top -->

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('vitrine/lib/wow/wow.min.js') }}"></script>
    <script src="{{ url('vitrine/lib/easing/easing.min.js') }}"></script>
    <script src="{{ url('vitrine/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ url('vitrine/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ url('vitrine/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ url('vitrine/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ url('vitrine/js/main.js') }}"></script>
@stack('scripts')
</body>

</html>