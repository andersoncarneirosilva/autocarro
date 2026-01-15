<!DOCTYPE html>

<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Desenvolvemos sites e sistemas com design profissional, performance e foco em resultados. Fale com a Pix Design!" />
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Desenvolvimento de Sites e Sistemas com design profissional - Pix Design" />
    <meta property="og:description" content="A Pix Design desenvolve sites e sistemas personalizados para empresas e profissionais. Soluções digitais com desempenho e design de alto nível." />
    <meta property="og:url" content="https://pixdesign.com.br/"/>
    <meta property="og:site_name" content="Pix Design" />
    <title> Pix Design </title>
     
    <!-- ======= Google Font =======-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet">
    <!-- End Google Font-->
    
    <!-- ======= Styles =======-->
    <link href="{{ url('assets/pixdesign/vendors/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pixdesign/vendors/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pixdesign/vendors/glightbox/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pixdesign/vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pixdesign/vendors/aos/aos.css') }}" rel="stylesheet">
    <!-- End Styles-->
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ url('assets/pixdesign/images/favicon/favicon.ico') }}images/favicon/favicon.ico">
    <link rel="apple-touch-icon" href="i{{ url('assets/pixdesign/mages/favicon/apple-touch-icon.png') }}mages/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('assets/pixdesign/images/favicon/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('assets/pixdesign/images/favicon/apple-touch-icon-114x114.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
      const lightbox = GLightbox({ selector: '.glightbox' });
    </script>


    <!-- ======= Theme Style =======-->
    <link href="{{ url('assets/pixdesign/css/style.css') }}" rel="stylesheet">
    <!-- End Theme Style-->
    
    <!-- ======= Apply theme =======-->
    <script>
      // Apply the theme as early as possible to avoid flicker
      (function() {
      const storedTheme = localStorage.getItem('theme') || 'light';
      document.documentElement.setAttribute('data-bs-theme', storedTheme);
      })();
    </script>
  </head>
  <body>
    
    
    <!-- ======= Site Wrap =======-->
    <div class="site-wrap">
      
      
      <!-- ======= Header =======-->
      <header class="fbs__net-navbar navbar navbar-expand-lg dark" aria-label="navbar">
        <div class="container d-flex align-items-center justify-content-between">
          
          
          <!-- Start Logo-->
          <a class="navbar-brand w-auto" href="{{ route('site.index') }}">
            
            <img class="logo dark img-fluid" src="{{ url('assets/pixdesign/images/logo.png') }}" width="50px"> 
            
            <img class="logo light img-fluid" src="{{ url('assets/pixdesign/images/logo-light.svg') }}" alt="image placeholder">
            
            </a>
          
          <!-- Start offcanvas-->
          <div class="offcanvas offcanvas-start w-75" id="fbs__net-navbars" tabindex="-1" aria-labelledby="fbs__net-navbarsLabel">
            
            
            <div class="offcanvas-header">
              <div class="offcanvas-header-logo">
                <a class="logo-link" id="fbs__net-navbarsLabel" href="{{ route('site.index') }}">
                  
                  
                  <img class="logo dark img-fluid" src="{{ url('assets/pixdesign/images/logo.png') }}" width="50px"> 
                  
                  <img class="logo light img-fluid" src="{{ url('assets/pixdesign/images/logo.png') }}" width="50px"></a>
                
              </div>
              <button class="btn-close btn-close-black" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body align-items-lg-center">
              
              
              <ul class="navbar-nav nav me-auto ps-lg-5 mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link scroll-link active" aria-current="page" href="#home">Página Inicial</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#sobre">Sobre</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#portfolio">Portfólio</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#planos">Planos</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#processos">Processos</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#servicos">Serviços</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="#contact">Contato</a></li>
                <li class="nav-item"><a class="nav-link scroll-link" href="{{ route('login') }}">Area restita</a></li>
              </ul>
              
            </div>
          </div>
          <!-- End offcanvas-->
          
          <div class="ms-auto w-auto">
            
            
            <div class="header-social d-flex align-items-center gap-1">
              <a class="btn btn-whats py-2" href="https://wa.me/5551999047299" target="_blank"><i class="fa fa-whatsapp"></i> Chame no Whats</a>
              
              <button class="fbs__net-navbar-toggler justify-content-center align-items-center ms-auto" data-bs-toggle="offcanvas" data-bs-target="#fbs__net-navbars" aria-controls="fbs__net-navbars" aria-label="Toggle navigation" aria-expanded="false">
                <svg class="fbs__net-icon-menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="21" x2="3" y1="6" y2="6"></line>
                  <line x1="15" x2="3" y1="12" y2="12"></line>
                  <line x1="17" x2="3" y1="18" y2="18"></line>
                </svg>
                <svg class="fbs__net-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
              
            </div>
            
          </div>
        </div>
      </header>
      <!-- End Header-->
      
      <!-- ======= Main =======-->
      <main>
        
        
        <!-- ======= Hero =======-->
        <section class="hero__v6 section" id="home">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="row">
          <div class="col-lg-11">
            <span class="hero-subtitle text-uppercase" data-aos="fade-up" data-aos-delay="0">Desenvolvimento Web Profissional</span>
            <h1 class="hero-title mb-3 text-white" data-aos="fade-up" data-aos-delay="100">Projetos que Entregam Resultados</h1>
            <p class="hero-description mb-4 mb-lg-5 text-white" data-aos="fade-up" data-aos-delay="200">
              Criamos sites modernos, responsivos e com foco total em performance. Sua presença online começa aqui, com design estratégico e soluções sob medida para seu negócio.
            </p>
            <div class="cta d-flex gap-2 mb-4 mb-lg-5" data-aos="fade-up" data-aos-delay="300">
              <a class="btn" href="https://wa.me/5551999047299" target="_blank">Solicitar Orçamento</a>
              <a class="btn" style="color: #215c5c; background: #fff;" href="#portfolio">Ver Portfólio
                <svg class="lucide lucide-arrow-up-right" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M7 7h10v10"></path>
                  <path d="M7 17 17 7"></path>
                </svg>
              </a>
            </div>
            <div class="logos mb-4" data-aos="fade-up" data-aos-delay="400">
              <!-- <span class="logos-title text-uppercase mb-4 d-block">Confiado por empresas de todos os portes</span> -->
              <!-- Aqui você pode inserir logotipos de clientes -->
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-img">
          <!-- <img class="img-card img-fluid" src="images/card-expenses.png" alt="Imagem card" data-aos="fade-down" data-aos-delay="600"> -->
          <!-- <img class="img-main img-fluid rounded-4" src="images/startup.svg" alt="Imagem principal" data-aos="fade-in" data-aos-delay="500">
            -->
          <div class="stats-card">
                <div class="stats-header">
                  <h3>FALE COM NOSSO TIME</h3>
                  <div class="decoration-line"></div><br>
                  <p>Respondemos diretamente no WhatsApp</p>
                </div>
                <form id="whatsappForm">
                  <div class="row gy-2">
                    <div class="col-12">
                      <div class="form-group">
                        <div class="input-with-icon">
                          <input type="text" class="form-control" name="name" placeholder="Seu nome" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <div class="input-with-icon">
                          <select class="form-select" name="subject" required>
                            <option value="">Selecione o assunto</option>
                            <option value="Consultoria">Orçamento</option>
                            <option value="Suporte Técnico">Suporte</option>
                            <option value="Outro">Outro</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <textarea class="form-control" name="message" rows="2" placeholder="Escreva sua mensagem..." required></textarea>
                      </div>
                    </div>

                    <div class="col-12 text-center">
                      <button type="submit" class="btn btn-success btn-submit w-100">ENVIAR NO WHATSAPP</button>
                    </div>
                  </div>
                </form>
                <script>
  document.getElementById("whatsappForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const name = encodeURIComponent(this.name.value.trim());
    const subject = encodeURIComponent(this.subject.value.trim());
    const message = encodeURIComponent(this.message.value.trim());

    // Substitua pelo número do seu WhatsApp (com DDI e DDD, sem espaços ou traços)
    const phoneNumber = "5551999047299"; // exemplo: 55 + DDD + número

    const fullMessage = `Olá, meu nome é ${name}. Assunto: ${subject}. Mensagem: ${message}`;

    const whatsappURL = `https://wa.me/${phoneNumber}?text=${fullMessage}`;

    window.open(whatsappURL, "_blank");
  });
</script>

              </div>
        </div>
      </div>
    </div>
  </div>
</section>

        <!-- End Hero-->
        
        <!-- ======= About =======-->
        <section class="about__v4 section" id="sobre">
  <div class="container">
    <div class="row">
      <div class="col-md-6 order-md-2">
        <div class="row justify-content-end">
          <div class="col-md-11 mb-4 mb-md-0">
            <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Sobre nós</span>
            <h2 class="mb-4" data-aos="fade-up" data-aos-delay="100">Há 15 anos desenvolvendo soluções digitais que transformam negócios</h2>
            <div data-aos="fade-up" data-aos-delay="200">
              <p>Com 15 anos de experiência no mercado, a Pix Design é referência em desenvolvimento de sites e sistemas sob medida. Unimos tecnologia, design e estratégia para entregar soluções digitais de alto desempenho.</p>
              <p>Atendemos empresas de todos os portes com projetos personalizados, garantindo presença digital forte, segura e alinhada aos objetivos de cada cliente.</p>
            </div>
            <h4 class="small fw-bold mt-4 mb-3" data-aos="fade-up" data-aos-delay="300">Nossos pilares</h4>
            <ul class="d-flex flex-row flex-wrap list-unstyled gap-3 features" data-aos="fade-up" data-aos-delay="400">
              <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Experiência</span></li>
              <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Qualidade</span></li>
              <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Inovação</span></li>
              <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Comprometimento</span></li>
              <li class="d-flex align-items-center gap-2"><span class="icon rounded-circle text-center"><i class="bi bi-check"></i></span><span class="text">Resultados</span></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6"> 
        <div class="img-wrap position-relative">
          <img class="img-fluid rounded-4" src="{{ url('assets/pixdesign/images/about_2-min.jpg') }}" alt="Imagem institucional" data-aos="fade-up" data-aos-delay="0">
          <div class="mission-statement p-4 rounded-4 d-flex gap-4" data-aos="fade-up" data-aos-delay="100">
            <div class="mission-icon text-center rounded-circle"><i class="bi bi-lightbulb fs-4"></i></div>
            <div>
              <h3 class="text-uppercase fw-bold">Nossa missão</h3>
              <p class="fs-5 mb-0">Oferecer soluções digitais eficientes, seguras e personalizadas que ajudem nossos clientes a crescerem no ambiente online.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

        <!-- End About-->
        
        <!-- ======= Features =======-->
        <section class="section features__v2" id="portfolio">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-lg-flex p-5 rounded-4 content" data-aos="fade-in" data-aos-delay="0">
          <div class="row">
            <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="0">
              <div class="row"> 
                <div class="col-lg-11">
                  <div class="h-100 flex-column justify-content-between d-flex">
                    <div>
                      <h2 class="mb-4">Portfólio</h2>
                      <p class="mb-5">Confira alguns dos nossos trabalhos em desenvolvimento de sites e sistemas personalizados. Criamos soluções modernas, responsivas e alinhadas com os objetivos de cada cliente.</p>
                    </div>
                    <div class="align-self-start">
                      <a class="btn btn-primary" href="https://wa.me/5551999047299" target="_blank">Solicite um orçamento</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <div class="row justify-content-end">
                <div class="col-lg-11">
                  <div class="row g-3">
                    
                     <div class="col-sm-6" data-aos="fade-up" data-aos-delay="300">
                      <a href="{{ url('assets/pixdesign/images/portfolio/project_6.jpg') }}" class="glightbox" data-gallery="portfolio">
                        <img src="{{ url('assets/pixdesign/images/portfolio/project_6.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Projeto 4">
                      </a>
                    </div>

                    <div class="col-sm-6" data-aos="fade-up" data-aos-delay="0">
                      <a href="{{ url('assets/pixdesign/images/portfolio/project_1.jpg') }}" class="glightbox" data-gallery="portfolio">
                        <img src="{{ url('assets/pixdesign/images/portfolio/project_1.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Projeto 1">
                      </a>
                    </div>
                    
                    <div class="col-sm-6" data-aos="fade-up" data-aos-delay="100">
                      <a href="{{ url('assets/pixdesign/images/portfolio/project_2.jpg') }}" class="glightbox" data-gallery="portfolio">
                        <img src="{{ url('assets/pixdesign/images/portfolio/project_2.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Projeto 2">
                      </a>
                    </div>
                    
                    <div class="col-sm-6" data-aos="fade-up" data-aos-delay="200">
                      <a href="{{ url('assets/pixdesign/images/portfolio/project_3.jpg') }}" class="glightbox" data-gallery="portfolio">
                        <img src="{{ url('assets/pixdesign/images/portfolio/project_3.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Projeto 3">
                      </a>
                    </div>
                    
                    <div class="col-sm-6" data-aos="fade-up" data-aos-delay="300">
                      <a href="{{ url('assets/pixdesign/images/portfolio/project_4.jpg') }}" class="glightbox" data-gallery="portfolio">
                        <img src="{{ url('assets/pixdesign/images/portfolio/project_4.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Projeto 4">
                      </a>
                    </div>
                    
                    <div class="col-sm-6" data-aos="fade-up" data-aos-delay="300">
                      <a href="{{ url('assets/pixdesign/images/portfolio/project_5.jpg') }}" class="glightbox" data-gallery="portfolio">
                        <img src="{{ url('assets/pixdesign/images/portfolio/project_5.jpg') }}" class="img-fluid rounded-3 shadow-sm" alt="Projeto 4">
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

        <!-- End Features-->
        
        <!-- ======= Pricing =======-->
        <section class="section pricing__v2" id="planos">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-5 mx-auto text-center">
        <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Planos</span>
        <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Uma solução para cada necessidade</h2>
        <p data-aos="fade-up" data-aos-delay="200">Escolha o plano ideal para seu projeto e leve sua presença digital para o próximo nível.</p>
      </div>
    </div>
    <div class="row">
      <!-- Plano Pessoal -->
      <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
        <div class="p-5 rounded-4 price-table h-100">
          <h3>LANDING PAGE</h3>
<p>Perfeita para divulgar um serviço, produto ou campanha com foco em conversão. Tudo em uma única página estratégica, moderna e responsiva.</p>

          <div class="price mb-4"><strong>R$199</strong><span> único</span></div>
          <div><a class="btn" href="https://wa.me/5551999047299" target="_blank">Chame no Whats</a></div>
        </div>
      </div>

      <!-- Plano Profissional -->
      <div class="col-md-8" data-aos="fade-up" data-aos-delay="400">
        <div class="p-5 rounded-4 price-table popular h-100">
          <div class="row">
            <div class="col-md-6">
              <h3 class="mb-3">WEBSITE</h3>
              <p>Perfeito para empresas que precisam de um site dinâmico, com navegação intuitiva e funcionalidades sob medida.</p>
              <div class="price mb-4"><strong class="me-1">R$399</strong><span> único</span></div>
              <div><a class="btn btn-white hover-outline" href="https://wa.me/5551999047299" target="_blank">Solicitar proposta</a></div>
            </div>
            <div class="col-md-6 pricing-features">
              <h4 class="text-uppercase fw-bold mb-3">Inclui</h4>
              <ul class="list-unstyled d-flex flex-column gap-3">
                <li class="d-flex gap-2 align-items-start mb-0">
                  <span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span>
                  <span>Design personalizado e responsivo</span>
                </li>
                <li class="d-flex gap-2 align-items-start mb-0">
                  <span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span>
                  <span>Emails personalizados</span>
                </li>
                <li class="d-flex gap-2 align-items-start mb-0">
                  <span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span>
                  <span>Otimização básica para Google</span>
                </li>
                <li class="d-flex gap-2 align-items-start mb-0">
                  <span class="icon rounded-circle position-relative mt-1"><i class="bi bi-check"></i></span>
                  <span>Sem mensalidades</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

        <!-- End Pricing-->
        
        <!-- ======= How it works =======-->
        <section class="section howitworks__v1" id="processos">
          <div class="container">
            <div class="row mb-5">
  <div class="col-md-6 text-center mx-auto">
    <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Nosso processo</span>
    <h2 data-aos="fade-up" data-aos-delay="100">Como desenvolvemos seu projeto</h2>
    <p data-aos="fade-up" data-aos-delay="200">
      Nosso processo é claro, eficiente e personalizado. Acompanhe as etapas que seguimos para transformar sua ideia em um site moderno e funcional:
    </p>
  </div>
</div>

            <div class="row g-md-5">
  <!-- Etapa 1 -->
  <div class="col-md-6 col-lg-3">
    <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative" data-aos="fade-up" data-aos-delay="0">
      <div data-aos="fade-right" data-aos-delay="500">
        <img class="arch-line" src="{{ url('assets/pixdesign/images/arch-line.svg') }}" alt="image placeholder">
      </div>
      <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">1</span>
      <div>
        <h3 class="fs-5 mb-4">1. Ideia</h3>
        <p>Você compartilha sua necessidade e juntos definimos o estilo do site.</p>
      </div>
    </div>
  </div>

  <!-- Etapa 2 -->
  <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="600">
    <div class="step-card reverse text-center h-100 d-flex flex-column justify-content-start position-relative">
      <div data-aos="fade-right" data-aos-delay="1100">
        <img class="arch-line reverse" src="{{ url('assets/pixdesign/images/arch-line-reverse.svg') }}" alt="image placeholder">
      </div>
      <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">2</span>
      <h3 class="fs-5 mb-4">2. Design</h3>
      <p>Com base na sua ideia, criamos um layout moderno e responsivo.</p>
    </div>
  </div>

  <!-- Etapa 3 -->
  <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="1200">
    <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative">
      <div data-aos="fade-right" data-aos-delay="1700">
        <img class="arch-line" src="{{ url('assets/pixdesign/images/arch-line.svg') }}" alt="image placeholder">
      </div>
      <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">3</span>
      <h3 class="fs-5 mb-4">3. Desenvolvimento</h3>
      <p>Transformamos o design em um site funcional, leve, otimizado e pronto para atrair resultados.</p>
    </div>
  </div>

  <!-- Etapa 4 -->
  <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="1800">
    <div class="step-card last text-center h-100 d-flex flex-column justify-content-start position-relative">
      <span class="step-number rounded-circle text-center fw-bold mb-5 mx-auto">4</span>
      <div>
        <h3 class="fs-5 mb-4">4. Resultado</h3>
        <p>Você recebe um site profissional, com email personalizado e pronto para obter uma presença online.</p>
      </div>
    </div>
  </div>
</div>

          </div>
        </section>
        <!-- End How it works-->
        
        <!-- ======= Stats =======-->
        <section class="stats__v3 section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex flex-wrap content rounded-4" data-aos="fade-up" data-aos-delay="0">
          <div class="rounded-borders">
            <div class="rounded-border-1"></div>
            <div class="rounded-border-2"></div>
            <div class="rounded-border-3"></div>
          </div>

          <!-- Satisfação -->
          <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-item">
              <h3 class="fs-1 fw-bold">
                <span class="purecounter" data-purecounter-start="0" data-purecounter-end="155" data-purecounter-duration="2">0</span><span></span>
              </h3>
              <p class="mb-0">Projetos entregues com excelência</p>
            </div>
          </div>

          <!-- Performance -->
          <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-item">
              <h3 class="fs-1 fw-bold">
                <span class="purecounter" data-purecounter-start="0" data-purecounter-end="95" data-purecounter-duration="2">0</span><span>%</span>
              </h3>
              <p class="mb-0">Clientes satisfeitos com o resultado</p>
            </div>
          </div>

          <!-- Crescimento -->
          <div class="col-12 col-sm-6 col-md-4 mb-4 mb-md-0 text-center" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-item">
              <h3 class="fs-1 fw-bold">
                <span class="purecounter" data-purecounter-start="0" data-purecounter-end="3" data-purecounter-duration="2">0</span><span>x</span>
              </h3>
              <p class="mb-0">Mais visibilidade para nossos clientes</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

        <!-- End Stats-->
        
        <!-- ======= Services =======-->
        <section class="section services__v3" id="servicos">
          <div class="container">
            <div class="row mb-5">
              <div class="col-md-8 mx-auto text-center"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Nossos Serviços</span>
                <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Potencializando Negócios com Soluções Digitais Inovadoras</h2>
              </div>
            </div>
            
            <div class="row g-4">
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                  <div><span class="icon mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewbox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                          <path d="M50.327 4H25.168a6.007 6.007 0 0 0-6 6v5.11h-8.375a3.154 3.154 0 0 0-3.12 3.18v5.47a1 1 0 0 0 .724.961 3.204 3.204 0 0 1 0 6.097 1 1 0 0 0-.724.962v5.49a3.154 3.154 0 0 0 3.12 3.18H34.5c-2.147 8.057 9.408 12.135 12.77 4.441a1 1 0 0 0-1.841-.779 4.778 4.778 0 1 1-4.403-6.636c1.039-.159 2.453 1.082 3.063-.225.449-1.37-1.383-1.598-2.336-1.734V31.8a1 1 0 0 0-.72-.96 3.21 3.21 0 0 1 0-6.11 1 1 0 0 0 .72-.96v-5.48a3.154 3.154 0 0 0-3.12-3.18H21.168V10a4.004 4.004 0 0 1 4-4h3.21l1.24 3.066a3.982 3.982 0 0 0 3.708 2.503h8.826a3.984 3.984 0 0 0 3.71-2.503L47.1 6h3.228a4.004 4.004 0 0 1 4 4v1.6a1 1 0 0 0 2 0V10a6.007 6.007 0 0 0-6-6ZM38.633 17.11a1.153 1.153 0 0 1 1.12 1.18v4.792a5.234 5.234 0 0 0 0 9.405V35.6a6.789 6.789 0 0 0-4.333 2.85H10.793a1.153 1.153 0 0 1-1.12-1.18v-4.8a5.232 5.232 0 0 0 0-9.401V18.29a1.153 1.153 0 0 1 1.12-1.18Zm5.375-8.793a1.994 1.994 0 0 1-1.856 1.252h-8.826a1.991 1.991 0 0 1-1.854-1.252l-.934-2.312H44.94Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M55.327 14.6a1 1 0 0 0-1 1V54a4.004 4.004 0 0 1-4 4H25.168a4.004 4.004 0 0 1-4-4V43.45a1 1 0 0 0-2 0V54a6.007 6.007 0 0 0 6 6h25.16a6.007 6.007 0 0 0 6-6V15.6a1 1 0 0 0-1-1Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M41.185 54.52a1 1 0 0 0 0-2h-6.891a1 1 0 0 0 0 2ZM24.713 28.383a.853.853 0 1 1-.835 1.028.998.998 0 0 0-1.184-.775c-1.765.61-.18 2.94 1.017 3.265-.271 1.919 2.27 1.926 2-.003a2.852 2.852 0 0 0-.998-5.515.851.851 0 1 1 .821-1.084 1 1 0 0 0 1.926-.54 2.857 2.857 0 0 0-1.749-1.893v-.518a1 1 0 0 0-2 0v.521a2.852 2.852 0 0 0 1.002 5.514Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M24.713 36.43a9.092 9.092 0 0 0 9.082-9.082c-.499-12.047-17.666-12.045-18.163 0a9.092 9.092 0 0 0 9.08 9.082Zm0-16.163a7.09 7.09 0 0 1 7.082 7.081c-.371 9.388-13.793 9.387-14.163 0a7.09 7.09 0 0 1 7.08-7.081ZM46.413 37.53l-4.757 4.757-1.68-1.68a1 1 0 0 0-1.413 1.415l2.386 2.386a1 1 0 0 0 1.414 0l5.464-5.464a1 1 0 0 0-1.414-1.414Z" fill="currentColor" opacity="1" data-original="#000000"></path>
                        </g>
                      </svg></span>
                    <h3 class="fs-5 mb-3">Criação de Sites</h3>
                    <p class="mb-4">Soluções modernas, responsivas e sob medida para negócios que buscam presença digital forte e conversão eficiente.</p>
                  </div>
                  <!-- <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" href="#"><span class="icons"><i class="icon-1 bi bi-arrow-right-short"></i><i class="icon-2 bi bi-arrow-right-short"> </i></span><span>Read more</span></a> -->
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                  <div><span class="icon mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewbox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                          <path d="m57.936 58.647-4.47-11.871a9.542 9.542 0 0 0-5.914-5.693l-7.659-2.609-1.944-2.116v-2.62a13.043 13.043 0 0 0 4.739-5.175 14.256 14.256 0 0 0 3.237.14 2.909 2.909 0 0 0 2.905-2.906v-5.382a2.895 2.895 0 0 0-1.495-2.523 13.84 13.84 0 0 0-2.807-7.777 1 1 0 0 0-1.597 1.205 11.879 11.879 0 0 1 2.386 6.19c-.012-.01-2.017.036-1.987-.023-4.064-11.113-18.668-11.126-22.702.024h-1.875c.73-9.938 13.556-14.987 21.539-8.81a1 1 0 0 0 1.196-1.605c-9.394-7.24-24.311-1.02-24.754 10.758a2.895 2.895 0 0 0-1.566 2.561v5.382a2.909 2.909 0 0 0 2.905 2.906c.4-.042 2.932.115 3.213-.122a12.843 12.843 0 0 0 4.542 5.038v2.757l-1.825 2.184-7.553 2.521a9.547 9.547 0 0 0-5.917 5.695l-4.47 11.871a1.008 1.008 0 0 0 .935 1.352H49.97a1 1 0 0 0 0-2H36.123l-2.985-7.876 2.014-2.491 2.009 1.746a1.007 1.007 0 0 0 1.643-.594l1.322-8.118 6.785 2.312a7.549 7.549 0 0 1 4.682 4.504L55.555 58H53.97a1 1 0 0 0 0 2H57a1.007 1.007 0 0 0 .936-1.353zm-13.77-39.136h1.759a.906.906 0 0 1 .905.904v5.382a.906.906 0 0 1-.905.906h-1.759zm-24.334 7.192h-1.759a.906.906 0 0 1-.905-.906v-5.382a.906.906 0 0 1 .905-.904h1.76s.038 5.959 0 7.192zm12.146-15.6a10.16 10.16 0 0 1 9.15 6.288L38.85 18.43a4.677 4.677 0 0 1-4.986-.747 6.633 6.633 0 0 0-7.78-.736l-3.91 2.325c1.2-4.704 5.135-8.169 9.803-8.169zM21.832 23.168V21.8l5.273-3.133a4.632 4.632 0 0 1 5.433.51 6.72 6.72 0 0 0 7.15 1.07l2.098-.957a12.113 12.113 0 0 1 .38 2.98c-.464 14.245-18.826 15.065-20.334.9zM35.95 34.706v1.718l-3.968 5.464-4.153-5.473v-1.78a11.242 11.242 0 0 0 8.12.071zm-9.164 3.643 3.852 5.075-3.771 3.28-1.206-7.008zM8.444 58l3.96-10.516a7.551 7.551 0 0 1 4.681-4.505l6.724-2.245 1.387 8.06a1.007 1.007 0 0 0 1.641.585l2.01-1.746 2.013 2.491L27.875 58zm25.54 0h-3.97L32 52.763zm-1.985-9.65-1.642-2.03 1.642-1.428 1.642 1.427zm5.12-1.658-3.772-3.28 3.693-5.085 1.224 1.332z" fill="currentColor" opacity="1" data-original="currentColor"></path>
                        </g>
                      </svg></span>
                    <h3 class="fs-5 mb-3">Sistemas Web</h3>
                    <p class="mb-4">Construímos sistemas personalizados para automatizar processos, integrar dados e facilitar a gestão do seu negócio online.</p>
                  </div>
                  <!-- <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" href="#"><span class="icons"><i class="icon-1 bi bi-arrow-right-short"></i><i class="icon-2 bi bi-arrow-right-short"> </i></span><span>Read more</span></a> -->
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                  <div><span class="icon mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewbox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                          <path d="M35.719 21.413a1 1 0 0 0-1.586 1.218 15.554 15.554 0 0 1 1.806 3.012h-6.1a19.93 19.93 0 0 0-3.417-8.42 15.637 15.637 0 0 1 5.012 2.652 1 1 0 0 0 1.245-1.565 17.676 17.676 0 1 0-11.002 31.51c14.511.067 22.936-16.94 14.042-28.407zm.966 6.23a15.507 15.507 0 0 1 .001 8.994h-6.533a35.942 35.942 0 0 0-.001-8.995zM29.84 38.635h6.102a15.688 15.688 0 0 1-9.534 8.447 19.91 19.91 0 0 0 3.432-8.447zm-1.402-6.491a34.461 34.461 0 0 1-.292 4.492h-12.94a34.731 34.731 0 0 1 .001-8.995h12.938a34.461 34.461 0 0 1 .293 4.503zm-6.812-15.67c2.533-.006 5.021 3.488 6.193 9.168H15.535c1.138-5.63 3.672-9.12 6.092-9.168zm-4.683.734a19.903 19.903 0 0 0-3.429 8.434H7.417a15.707 15.707 0 0 1 9.527-8.434zM6 32.149a15.682 15.682 0 0 1 .671-4.507h6.53a35.936 35.936 0 0 0 0 8.995H6.67A15.558 15.558 0 0 1 6 32.15zm1.413 6.487h6.1a19.912 19.912 0 0 0 3.43 8.446 15.69 15.69 0 0 1-9.53-8.446zm8.118 0h12.29c-2.589 12.171-9.703 12.166-12.29 0zM16.844 8.31H38.91a8.42 8.42 0 0 1 8.4 8.106l-2.018-2.018a1 1 0 0 0-1.414 1.414l3.74 3.74a1 1 0 0 0 1.414 0l3.74-3.74a1 1 0 0 0-1.413-1.414l-2.048 2.047A10.421 10.421 0 0 0 38.911 6.31H16.844a1 1 0 0 0 0 2zM50.105 44.448a1 1 0 0 0-1.413 0l-3.74 3.74a1 1 0 1 0 1.413 1.414l2.018-2.018a8.419 8.419 0 0 1-8.4 8.107H17.916a1 1 0 0 0 0 2h22.067a10.42 10.42 0 0 0 10.401-10.136l2.048 2.047a1 1 0 0 0 1.413-1.414zM58.589 27.13a1 1 0 0 0-1.694 1.062 7.174 7.174 0 1 1-2.549-2.453 1 1 0 1 0 .992-1.736 9.2 9.2 0 1 0-4.545 17.195c7.082.128 11.668-8.14 7.796-14.068z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M49.754 34.379a1.001 1.001 0 0 0-1.238-.682c-1.769.767.123 2.972 1.275 3.302a1 1 0 1 0 2-.024 3.075 3.075 0 0 0-1-5.975 1.078 1.078 0 1 1 1.053-1.306 1 1 0 0 0 1.187.77c1.894-.7-.034-3.134-1.24-3.463a1 1 0 1 0-2 .024 3.075 3.075 0 0 0 1 5.975 1.079 1.079 0 1 1-1.037 1.379z" fill="currentColor" opacity="1" data-original="#000000"></path>
                        </g>
                      </svg></span>
                    <h3 class="fs-5 mb-3">Landing Pages</h3>
                    <p class="mb-4">Desenvolvemos páginas de alta conversão focadas em vendas, lançamentos e geração de leads com layout profissional e velocidade de carregamento.</p>
                  </div>
                  <!-- <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" href="#"><span class="icons"><i class="icon-1 bi bi-arrow-right-short"></i><i class="icon-2 bi bi-arrow-right-short"> </i></span><span>Read more</span></a> -->
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                  <div><span class="icon mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewbox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                          <path d="M59 47.487h-1.81v-27.61a5.223 5.223 0 0 0-5-5.409h-3.71a1 1 0 0 0 0 2h3.71a3.228 3.228 0 0 1 3 3.41v27.609H26.03a1.013 1.013 0 0 0-.996 1.02 34.358 34.358 0 0 0 1.49 3.57 2 2 0 0 0 1.828 1.188h7.296a2 2 0 0 0 1.828-1.188l1.149-2.589L58 49.487v2.74a2.823 2.823 0 0 1-2.82 2.82H8.82A2.823 2.823 0 0 1 6 52.227v-2.74h16.03a1 1 0 0 0 0-2H8.81v-27.61a3.228 3.228 0 0 1 3-3.41h6.89c-3.535 9.154 3.658 19.594 13.63 19.48 11.076.08 18.127-12.336 12.587-21.706a14.54 14.54 0 0 0-25.162-.073 1.646 1.646 0 0 1-.163.299H11.81a5.223 5.223 0 0 0-5 5.41v27.61H5a1 1 0 0 0-1 1v3.74a4.825 4.825 0 0 0 4.82 4.82h46.36a4.825 4.825 0 0 0 4.82-4.82v-3.74a1 1 0 0 0-1-1zm-23.352 3.778h-7.296l-.788-1.775h8.872zm-4.332-17.37a12.517 12.517 0 0 1-9.29-5.372l2.072-1.196a10.137 10.137 0 0 0 7.218 4.188zm2 .001v-2.38a10.12 10.12 0 0 0 7.224-4.178l2.073 1.197a12.5 12.5 0 0 1-9.297 5.361zm11.521-12.471A12.435 12.435 0 0 1 43.61 26.8l-2.064-1.192a10.127 10.127 0 0 0 .008-8.344l2.064-1.192a12.412 12.412 0 0 1 1.22 5.353zM33.33 8.967a12.503 12.503 0 0 1 9.295 5.37l-2.073 1.196a10.124 10.124 0 0 0-7.222-4.187zm7.129 12.458a8.144 8.144 0 0 1-8.13 8.14c-10.794-.446-10.804-15.824 0-16.27a8.138 8.138 0 0 1 8.13 8.13zM31.329 8.966v2.38a10.138 10.138 0 0 0-7.226 4.177l-2.073-1.196a12.518 12.518 0 0 1 9.3-5.36zm-10.295 7.095 2.064 1.192a10.022 10.022 0 0 0-.003 8.343l-2.064 1.192a12.473 12.473 0 0 1 .003-10.727z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M32.322 22.446a1.276 1.276 0 1 1-1.225 1.632 1 1 0 0 0-1.921.556 3.29 3.29 0 0 0 2.146 2.202v.352a1 1 0 0 0 2 0v-.363a3.272 3.272 0 0 0-1-6.38A1.276 1.276 0 1 1 33.57 18.9a1 1 0 0 0 1.956-.418 3.287 3.287 0 0 0-2.204-2.423c.082-.687-.226-1.374-1-1.385-.78.016-1.08.697-1 1.392a3.272 3.272 0 0 0 1 6.38z" fill="currentColor" opacity="1" data-original="#000000"></path>
                        </g>
                      </svg></span>
                    <h3 class="fs-5 mb-3">Segurança e Otimização</h3>
                    <p class="mb-4">Aplicamos práticas modernas de segurança, backups e otimização de performance para garantir estabilidade e confiança ao seu site.</p>
                  </div>
                  <!-- <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" href="#"><span class="icons"><i class="icon-1 bi bi-arrow-right-short"></i><i class="icon-2 bi bi-arrow-right-short"> </i></span><span>Read more</span></a> -->
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                  <div><span class="icon mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewbox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                          <path d="M38.972 31.507a7.01 7.01 0 0 0-4.32-12.487H23.604a3.001 3.001 0 0 0-2.998 2.998v19.988a3.001 3.001 0 0 0 2.998 2.998h12.8c7.723-.104 9.639-10.635 2.568-13.497zm-16.367-9.49a1 1 0 0 1 1-.999h11.047a4.997 4.997 0 1 1 0 9.994H22.605zm13.798 20.988H23.604a1 1 0 0 1-.999-1v-8.994h13.798a4.997 4.997 0 0 1 0 9.994z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M51.798 12.238a27.71 27.71 0 0 0-3.132-2.708 1 1 0 0 0-1.186 1.609 25.317 25.317 0 0 1 2.162 1.82l-2.117 2.117A22.896 22.896 0 0 0 33.002 9.05V6.057a25.425 25.425 0 0 1 11.2 3.02 1 1 0 0 0 .946-1.761C26.702-2.634 3.907 11.036 4.02 32.012c-.31 15.036 12.945 28.294 27.983 27.983 24.827-.03 37.332-30.174 19.795-47.757zm-.734 2.126a25.768 25.768 0 0 1 6.899 16.648h-3A22.896 22.896 0 0 0 48.94 16.49zm-38.123 0 2.118 2.117A22.815 22.815 0 0 0 9.05 31.012H6.043a25.768 25.768 0 0 1 6.898-16.648zM6.043 33.01h2.999a22.896 22.896 0 0 0 6.025 14.524L12.94 49.66A25.768 25.768 0 0 1 6.043 33.01zm24.96 24.96a25.768 25.768 0 0 1-16.648-6.898l2.125-2.125a22.896 22.896 0 0 0 14.523 6.025zm-19.988-25.96a20.892 20.892 0 0 1 11.64-18.784 1 1 0 0 0-.892-1.788 23.283 23.283 0 0 0-5.294 3.626l-2.114-2.114a25.768 25.768 0 0 1 16.648-6.9v3.01a22.7 22.7 0 0 0-5.356.865 1 1 0 0 0 .558 1.918c13.1-3.976 26.996 6.454 26.785 20.168-1.15 27.836-40.823 27.84-41.975 0zm21.987 25.96v-2.998a22.896 22.896 0 0 0 14.523-6.025l2.125 2.125a25.768 25.768 0 0 1-16.648 6.899zm18.062-8.311-2.125-2.125a22.896 22.896 0 0 0 6.024-14.524h3a25.768 25.768 0 0 1-6.9 16.649z" fill="currentColor" opacity="1" data-original="#000000"></path>
                        </g>
                      </svg></span>
                    <h3 class="fs-5 mb-3">Hospedagem e Suporte</h3>
                    <p class="mb-4">Oferecemos soluções de hospedagem confiáveis, com suporte técnico e manutenção para manter seu projeto no ar com excelência.</p>
                  </div>
                  <!-- <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" href="#"><span class="icons"><i class="icon-1 bi bi-arrow-right-short"></i><i class="icon-2 bi bi-arrow-right-short"> </i></span><span>Read more</span></a> -->
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                <div class="service-card p-4 rounded-4 h-100 d-flex flex-column justify-content-between gap-5">
                  <div><span class="icon mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewbox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                          <path d="M49.5 4H24.34a6.007 6.007 0 0 0-6 6v5.29a1 1 0 0 0 2 0V10a4.005 4.005 0 0 1 4-4h3.218l1.237 3.066a3.984 3.984 0 0 0 3.71 2.503h8.826a3.984 3.984 0 0 0 3.71-2.503L46.277 6H49.5a4.004 4.004 0 0 1 4 4v44a4.004 4.004 0 0 1-4 4H24.34a4.005 4.005 0 0 1-4-4V39.42h11.8a6.774 6.774 0 0 0 12.998 2.159 1 1 0 0 0-1.842-.78 4.778 4.778 0 1 1-2.638-6.3 1 1 0 0 0 1.298-.56c.446-1.634-1.965-1.701-3.062-1.776a6.785 6.785 0 0 0-6.6 5.257H13.502a3.003 3.003 0 0 1-3-3v-7.932h27.4v2.672a1 1 0 0 0 2 0v-5.87a5.006 5.006 0 0 0-5-5H13.5a5.006 5.006 0 0 0-5 5c.007 1.424-.005 9.521 0 11.13a5.006 5.006 0 0 0 5 5h4.84V54a6.007 6.007 0 0 0 6 6H49.5a6.007 6.007 0 0 0 6-6V10a6.007 6.007 0 0 0-6-6zm-6.314 4.317a1.994 1.994 0 0 1-1.855 1.252h-8.827a1.992 1.992 0 0 1-1.854-1.252l-.934-2.312H44.12zM10.501 23.29a3.003 3.003 0 0 1 3-3h21.4a3.003 3.003 0 0 1 3 3v1.198H10.5z" fill="currentColor" opacity="1" data-original="#000000"></path>
                          <path d="M33.472 52.52a1 1 0 0 0 0 2h6.89a1 1 0 0 0 0-2zM37.844 37.294a1 1 0 0 0-1.414 1.415l2.387 2.387a1 1 0 0 0 1.414 0l5.464-5.465a1 1 0 0 0-1.414-1.414l-4.757 4.757zM13.29 33.143a1 1 0 0 0 0 2h2.45a1 1 0 0 0 0-2z" fill="currentColor" opacity="1" data-original="#000000"></path>
                        </g>
                      </svg></span>
                    <h3 class="fs-5 mb-3">SEO e Performance</h3>
                    <p class="mb-4">Otimizamos o seu site para os mecanismos de busca (SEO), melhorando sua visibilidade e resultados orgânicos no Google.</p>
                  </div>
                  <!-- <a class="special-link d-inline-flex gap-2 align-items-center text-decoration-none" href="#"><span class="icons"><i class="icon-1 bi bi-arrow-right-short"></i><i class="icon-2 bi bi-arrow-right-short"> </i></span><span>Read more</span></a> -->
                </div>
              </div>
            </div>

          </div>
        </section>
        <!-- Services-->
        
        <!-- ======= Testimonials =======-->
        <!-- <section class="section testimonials__v2" id="testimonials">
          <div class="container">
            <div class="row mb-5">
              <div class="col-lg-5 mx-auto text-center"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Testimonials</span>
                <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">What Our Users Are Saying</h2>
                <p data-aos="fade-up" data-aos-delay="200">Real Stories of Success and Satisfaction from Our Diverse Community</p>
              </div>
            </div>
            <div class="row g-4" data-masonry="{&quot;percentPosition&quot;: true }">
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                <div class="testimonial rounded-4 p-4">
                  <blockquote class="mb-3">
                     &ldquo;
                    This platform has completely transformed the way I manage my business finances. The real-time transaction tracking and seamless payment options have saved me so much time and effort!
                    &rdquo;
                  </blockquote>
                  <div class="testimonial-author d-flex gap-3 align-items-center">
                    <div class="author-img"><img class="rounded-circle img-fluid" src="images/person-sq-2-min.jpg" alt="image placeholder"></div>
                    <div class="lh-base"><strong class="d-block">John Davis</strong><span>Small Business Owner</span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial rounded-4 p-4">
                  <blockquote class="mb-3">
                     &ldquo;
                    As a freelancer, managing my finances can be overwhelming. The budgeting tools and personalized insights have made it so much easier to stay on top of my expenses and plan for the future.
                    &rdquo;
                  </blockquote>
                  <div class="testimonial-author d-flex gap-3 align-items-center">
                    <div class="author-img"><img class="rounded-circle img-fluid" src="images/person-sq-1-min.jpg" alt="image placeholder"></div>
                    <div class="lh-base"><strong class="d-block">Emily Smith</strong><span>Freelancer</span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial rounded-4 p-4">
                  <blockquote class="mb-3">
                     &ldquo;
                    The investment options and portfolio management tools on this platform are top-notch. The variety of choices caters to all types of investors, from conservative to aggressive. I especially appreciate how the tailored recommendations align perfectly with my financial goals. It’s a game-changer for anyone serious about growing their wealth.
                    &rdquo;
                  </blockquote>
                  <div class="testimonial-author d-flex gap-3 align-items-center">
                    <div class="author-img"><img class="rounded-circle img-fluid" src="images/person-sq-5-min.jpg" alt="image placeholder"></div>
                    <div class="lh-base"><strong class="d-block">Michael Rodriguez</strong><span>Investor</span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial rounded-4 p-4">
                  <blockquote class="mb-3">
                     &ldquo;
                    I never thought managing money could be this simple! The user-friendly interface and secure transaction process give me the confidence to handle my finances independently.
                    &rdquo;
                  </blockquote>
                  <div class="testimonial-author d-flex gap-3 align-items-center">
                    <div class="author-img"><img class="rounded-circle img-fluid" src="images/person-sq-3-min.jpg" alt="image placeholder"></div>
                    <div class="lh-base"><strong class="d-block">Sarah Lee</strong><span>College Student</span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                <div class="testimonial rounded-4 p-4">
                  <blockquote class="mb-3">
                     &ldquo;
                    The security features are outstanding. Knowing that my financial data is protected gives me peace of mind, and the platform's efficiency makes it a pleasure to use.
                    &rdquo;
                  </blockquote>
                  <div class="testimonial-author d-flex gap-3 align-items-center">
                    <div class="author-img"><img class="rounded-circle img-fluid" src="images/person-sq-7-min.jpg" alt="image placeholder"></div>
                    <div class="lh-base"><strong class="d-block">James Kim</strong><span>IT Consultant</span></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                <div class="testimonial rounded-4 p-4">
                  <blockquote class="mb-3">
                     &ldquo;
                    The platform’s intuitive design and robust features have been a game-changer for my startup. It’s helped me streamline operations and focus on growing my business.
                    &rdquo;
                  </blockquote>
                  <div class="testimonial-author d-flex gap-3 align-items-center">
                    <div class="author-img"><img class="rounded-circle img-fluid" src="images/person-sq-8-min.jpg" alt="image placeholder"></div>
                    <div class="lh-base"><strong class="d-block">Laura Brown</strong><span>Entrepreneur</span></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section> -->
        <!-- Testimonials-->
        
        <!-- ======= FAQ =======-->
        <section class="section faq__v2" id="faq">
  <div class="container">
    <div class="row mb-4">
      <div class="col-md-6 col-lg-7 mx-auto text-center">
        <span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">FAQ</span>
        <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">Perguntas Frequentes</h2>
        <p data-aos="fade-up" data-aos-delay="100">Tire suas dúvidas sobre nossos serviços de desenvolvimento web e saiba 
          como podemos ajudar no crescimento do seu negócio online.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto" data-aos="fade-up" data-aos-delay="200">
        <div class="faq-content">
          <div class="accordion custom-accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Quais serviços de desenvolvimento web vocês oferecem?
                </button>
              </h2>
              <div class="accordion-collapse collapse show" id="collapseOne">
                <div class="accordion-body">
                  Oferecemos desenvolvimento de sites institucionais, sistemas de gestão personalizados, 
                  otimização para mecanismos de busca (SEO), manutenção e suporte contínuo. 
                  Adaptamos cada projeto às necessidades específicas do cliente para garantir resultados eficazes.
                </div>
              </div>
            </div>
            
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Quanto custa criar um site?
                </button>
              </h2>
              <div class="accordion-collapse collapse" id="collapseTwo">
                <div class="accordion-body">
                  O custo varia conforme a complexidade do projeto, funcionalidades desejadas e prazo. 
                  Após entender suas necessidades, apresentamos um orçamento detalhado e transparente, com opções que cabem em diferentes orçamentos. Confira os planos <a href="#planos">aqui</a>
                </div>
              </div>
            </div>
            
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Quanto tempo leva para desenvolver um site?
                </button>
              </h2>
              <div class="accordion-collapse collapse" id="collapseThree">
                <div class="accordion-body">
                  O prazo depende do escopo do projeto. Sites simples geralmente ficam prontos em 3 a 7 dias se você fornecer o conteúdo, enquanto projetos mais complexos, como lojas virtuais ou sistemas personalizados, podem levar mais tempo. 
                  Mantemos comunicação constante para alinhar expectativas.
                </div>
              </div>
            </div>
            
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  O site será responsivo e funcionará bem em dispositivos móveis?
                </button>
              </h2>
              <div class="accordion-collapse collapse" id="collapseFour">
                <div class="accordion-body">
                  Sim! Todos os sites que desenvolvemos são responsivos, garantindo ótima experiência de navegação em smartphones, 
                  tablets e desktops, com design adaptado para cada tamanho de tela.
                </div>
              </div>
            </div>
            
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Vocês oferecem suporte e manutenção após o lançamento do site?
                </button>
              </h2>
              <div class="accordion-collapse collapse" id="collapseFive">
                <div class="accordion-body">
                  Sim, oferecemos pacotes de suporte e manutenção para manter seu site atualizado, seguro e funcionando corretamente. 
                  Incluímos atualizações, backups, monitoramento e atendimento para resolver eventuais problemas.
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End FAQ-->
</section>

        <!-- End FAQ-->
        
        <!-- ======= Contact =======-->
        <section class="section contact__v2" id="contact">
          <div class="container">
            <div class="row mb-5">
              <div class="col-md-6 col-lg-7 mx-auto text-center"><span class="subtitle text-uppercase mb-3" data-aos="fade-up" data-aos-delay="0">Contato</span>
                <h2 class="h2 fw-bold mb-3" data-aos="fade-up" data-aos-delay="0">Entre em contato</h2>
                <p data-aos="fade-up" data-aos-delay="100">Entre em contato e receba atendimento personalizado para esclarecer dúvidas.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex gap-5 flex-column">
                  <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="icon d-block"><i class="bi bi-telephone"></i></div><span> <span class="d-block">WhatsApp</span><strong>(51) 99904.7299</strong></span>
                  </div>
                  <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon d-block"><i class="bi bi-send"></i></div><span> <span class="d-block">Email</span><strong>contato@pixdesign.com.br</strong></span>
                  </div>
                  <!-- <div class="d-flex align-items-start gap-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon d-block"><i class="bi bi-geo-alt"></i></div><span> <span class="d-block">Address</span>
                      <address class="fw-bold">123 Main Street Apt 4B Springfield, <br> IL 62701 United States</address></span>
                  </div> -->
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-wrapper" data-aos="fade-up" data-aos-delay="300">
                  <form id="contact-form" action="forms/contact.php" method="post" class="php-email-form">
                    <div class="row gap-3 mb-3">
                      <div class="col-md-12">
                        <label class="mb-2" for="name">Nome</label>
                        <input class="form-control" id="name" type="text" name="name" required="" placeholder="Nome">
                      </div>
                      <div class="col-md-12">
                        <label class="mb-2" for="email">Email</label>
                        <input class="form-control" id="email" type="email" name="email" required="" placeholder="Seu melhor email">
                      </div>
                    </div>
                    <div class="row gap-3 gap-md-0 mb-3">
                      <div class="col-md-12">
                        <label class="mb-2" for="message">Mensagem</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required="" placeholder="Deixe sua mensagem"></textarea>
                      </div>
                    </div>
                    <button class="btn btn-primary fw-semibold" type="submit">Enviar</button>
                  </form>
                  <div id="form-message" class="mt-3"></div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End Contact-->
        
        <!-- ======= Footer =======-->
        <footer class="footer pt-5 pb-5">
          <div class="container">
            
            <div class="row justify-content-between mb-5 g-xl-5">
              <div class="col-lg-12">
                <h3 class="mb-3">
                  <img src="{{ url('assets/pixdesign/images/logo.png') }}" width="100px" alt="">
                </h3>
                <p class="mb-4">A Pix Design desenvolve sites e sistemas personalizados para empresas e profissionais. Soluções digitais com desempenho e design de alto nível.</p>
              </div>
             
            </div>
            <div class="row credits pt-3">
              <div class="col-xl-8 text-center text-xl-start mb-3 mb-xl-0">
                &copy;
                <script>document.write(new Date().getFullYear());</script> Pix Design. 
                  <i class="bi bi-heart-fill text-danger"></i> <a href="https://pixdesign.com.br">pixdesign.com.br</a>
              </div>
              <div class="col-xl-4 justify-content-start justify-content-xl-end quick-links d-flex flex-column flex-xl-row text-center text-xl-start gap-1">Responsável | <a href="#" target="_blank">Anderson</a></div>
            </div>
          </div>
        </footer>
        <!-- End Footer-->
        
      </main>
    </div>
    
    <!-- ======= Back to Top =======-->
    <button id="back-to-top"><i class="bi bi-arrow-up-short"></i></button>
    <!-- End Back to top-->
    <script src="https://kit.fontawesome.com/6c4df5f46b.js" crossorigin="anonymous"></script>
    <!-- ======= Javascripts =======-->
    <script src="{{ url('assets/pixdesign/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/pixdesign/vendors/gsap/gsap.min.js') }}"></script>
    <script src="{{ url('assets/pixdesign/vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/pixdesign/vendors/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/pixdesign/vendors/glightbox/glightbox.min.js') }}"></script>
    <script src="{{ url('assets/pixdesign/vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('assets/pixdesign/vendors/aos/aos.js') }}"></script>
    <script src="{{ url('assets/pixdesign/vendors/purecounter/purecounter.js') }}"></script>
    <script src="{{ url('assets/pixdesign/js/custom.js') }}"></script>

    <script>
  document.querySelector("#contact-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = e.target;
    const messageBox = document.getElementById("form-message");
    const formData = new FormData(form);

    fetch(form.action, {
      method: "POST",
      body: formData
    })
    .then(async (response) => {
      const text = await response.text();

      if (response.ok && text.trim() === "OK") {
        messageBox.innerHTML = '<div class="alert alert-success">Mensagem enviada com sucesso!</div>';
        form.reset();
      } else {
        messageBox.innerHTML = '<div class="alert alert-danger">' + text + '</div>';
      }
    })
    .catch(error => {
      messageBox.innerHTML = '<div class="alert alert-danger">Erro ao enviar: ' + error.message + '</div>';
    });
  });
</script>

    <!-- End JavaScripts-->
  </body>
</html>