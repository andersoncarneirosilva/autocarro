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

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="img/logo.png" alt=""> -->
        <h1 class="sitename">Autocar</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html" class="active">Home<br></a></li>
          <li><a href="about.html">Ofertas</a></li>
          <li><a href="about.html">Novos</a></li>
          <li><a href="courses.html">Semi-novos</a></li>
          <li><a href="trainers.html">Usados</a></li>
          <li class="dropdown"><a href="#"><span>Especiais</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Clássicos</a></li>
              <li><a href="#">Esportivos</a></li>
              <li><a href="#">Modificados</a></li>
              {{-- <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li> --}}
              
            </ul>
          </li>
          <li><a href="contact.html">Contato</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route('login') }}">ACESSAR</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="site/img/background-autocar.jpg" alt="" data-aos="fade-in">

      <div class="container">
    <h2 data-aos="fade-up" data-aos-delay="100">Encontre o carro ideal,<br>dirija seu futuro</h2>
    <p data-aos="fade-up" data-aos-delay="200">Somos especialistas em veículos seminovos e zero km com qualidade, <br>confiança e os melhores preços do mercado.</p>
    <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
        <a href="/estoque" class="btn-get-started">Ver Estoque</a>
    </div>
</div>


    </section><!-- /Hero Section -->


    <section id="why-us" class="section why-us">
  <div class="container">
    <div class="row gy-4">

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="why-box">
          <h3>Por que comprar conosco?</h3>
          <p>
            Oferecemos uma ampla variedade de veículos — carros, motos e utilitários — com procedência, garantia e preços justos. Aqui você encontra qualidade, confiança e um atendimento diferenciado do início ao fim da sua compra.
          </p>
          <div class="text-center">
            <a href="#estoque" class="more-btn"><span>Saiba mais</span> <i class="bi bi-chevron-right"></i></a>
          </div>
        </div>
      </div><!-- End Why Box -->

      <div class="col-lg-8 d-flex align-items-stretch">
        <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

          <div class="col-xl-4">
            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
              <i class="bi bi-clipboard-data"></i>
              <h4>Veículos revisados</h4>
              <p>Todos os veículos passam por vistoria e revisão completa antes de irem para o nosso estoque.</p>
            </div>
          </div><!-- End Icon Box -->

          <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
              <i class="bi bi-gem"></i>
              <h4>Garantia e procedência</h4>
              <p>Trabalhamos apenas com veículos com documentação em dia e histórico transparente.</p>
            </div>
          </div><!-- End Icon Box -->

          <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
              <i class="bi bi-inboxes"></i>
              <h4>Financiamento facilitado</h4>
              <p>Parceria com os principais bancos para oferecer as melhores condições de pagamento.</p>
            </div>
          </div><!-- End Icon Box -->

        </div>
      </div>

    </div>
  </div>
</section>


    <!-- Features Section -->
    <section id="features" class="features section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
  <div class="features-item" style="display: flex; justify-content: center;">
    <img src="site/img/marcas/audi.webp" alt="">
  </div>
</div>


          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/bmw.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/chevrolet.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/fiat.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/ford.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/honda.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/hyundai.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/nissan.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="900">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/peugeot.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1000">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/renault.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1100">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/toyota.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1200">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/volkswagem.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Courses Section -->
    <section id="courses" class="courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>OFERTAS</h2>
        <p>Mais vendidos</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          @foreach ($veiculos as $veiculo)
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
  <div class="course-item">
    @php
      $imagens = json_decode($veiculo->images, true) ?? [];
    @endphp

    @if (count($imagens) > 1)
      <div id="carousel{{ $veiculo->id }}" class="carousel slide" >
        
        <!-- Indicadores -->
        <div class="carousel-indicators">
          @foreach ($imagens as $index => $img)
            <button type="button" data-bs-target="#carousel{{ $veiculo->id }}" data-bs-slide-to="{{ $index }}"
              class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
              aria-label="Slide {{ $index + 1 }}"></button>
          @endforeach
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
          @foreach ($imagens as $index => $img)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
              <img src="{{ asset('storage/' . $img) }}" class="d-block w-100 img-fluid" alt="Imagem do veículo {{ $index + 1 }}">
            </div>
          @endforeach
        </div>

        <!-- Controles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $veiculo->id }}" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $veiculo->id }}" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Próxima</span>
        </button>
      </div>
    @else
      <img src="{{ count($imagens) ? asset('storage/' . $imagens[0]) : url('assets/img/default-car.png') }}" class="img-fluid" alt="Imagem do veículo">
    @endif

    <div class="course-content">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="category">{{ explode(' ', $veiculo->marca)[0] }}</p>
        <p class="price">R${{ $veiculo->valor }}</p>
      </div>
      <h3>{{ $veiculo->marca }}</h3>
      <p class="description">{{ $veiculo->kilometragem }}km | ANO: {{ $veiculo->ano }} | {{ $veiculo->cambio }}</p>
      <div class="trainer d-flex align-items-center justify-content-between">
        <p class="pchama mb-0 badge border border-success text-success bg-transparent">+ DETALHES</p>
        <div class="text-end">
          <p class="text-muted mb-0" style="text-decoration: line-through; font-size: 14px;">R$ {{ $veiculo->valor }}</p>
          <div class="ptext fw-bold" style="font-size: 20px;">R$ {{ $veiculo->valor_oferta }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

          @endforeach

        </div>

      </div>

    </section>

  </main>

  <footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Mentor</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Mentor</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href=“https://themewagon.com>ThemeWagon
      </div>
    </div>

  </footer>

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