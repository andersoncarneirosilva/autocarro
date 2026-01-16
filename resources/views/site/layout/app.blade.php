<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    
    <title>Alcecar | Gestão de Veículos e Automação de Procurações</title>
    <meta name="description" content="Automatize a geração de procurações, ATPVe e gerencie sua frota de veículos com facilidade. O sistema completo para despachantes e gestores de frota.">
    <meta name="keywords" content="gestão de frotas, automação de procurações, gerador de procuração, atpve, gerenciamento de veículos, sistema para despachantes">
    <meta name="author" content="Alcecar">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://alcecar.com.br/">
    <meta property="og:title" content="Gestão de Veículos e Automação de Procurações">
    <meta property="og:description" content="Otimize sua produtividade com nosso sistema de gestão automotiva. Geração de documentos em poucos cliques.">
    <meta property="og:image" content="{{ url('layout/images/background_alcecar.png') }}">

    <meta property="twitter:card" content="summary_large_image"> 
    <meta property="twitter:url" content="https://seusite.com.br/">
    <meta property="twitter:title" content="Gestão de Veículos e Automação de Procurações">
    <meta property="twitter:description" content="Otimize sua produtividade com nosso sistema de gestão automotiva.">
    <meta property="twitter:image" content="{{ url('layout/images/background_alcecar.png') }}">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ url('layout/images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ url('layout/css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('layout/css/LineIcons.2.0.css') }}">
    <link rel="stylesheet" href="{{ url('layout/css/bootstrap.4.5.2.min.css') }}">
    <link rel="stylesheet" href="{{ url('layout/css/default.css') }}">
    <link rel="stylesheet" href="{{ url('layout/css/style.css') }}">
    
</head>

<body>

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->
    <style>
   /* Estilo para dar respiro aos textos sem mudar o HTML */
.hero_text_center {
    text-align: center;
    position: relative;
    z-index: 5;
    /* Adiciona padding horizontal para o texto não colar nas laterais */
    padding: 0 15px; 
    /* Cria o distanciamento vertical em relação à imagem abaixo */
    margin-top: 180px; 
}

.hero_text_center h2 {
    font-size: 45px;
    color: #fff;
    font-weight: 700;
    margin-bottom: 25px;
    line-height: 1.2;
}

.hero_text_center p {
    color: rgba(255,255,255,0.9);
    font-size: 20px;
    line-height: 1.6;
    /* Limita a largura máxima do texto para ele não ficar esticado e "colado" */
    max-width: 850px; 
    margin: 0 auto; /* Centraliza o bloco de texto horizontalmente */
}

/* Garante que a imagem tenha um limite visual e não suba no texto */
.hero_image_main {
    margin-top: 20px;
    text-align: center;
}

.hero_image_main img {
    max-width: 100%;
    height: auto;
    filter: drop-shadow(0px 20px 40px rgba(0,0,0,0.3));
}

/* Ajuste para telas de celular */
@media (max-width: 767px) {
    .main_hero_custom, .header_hero {
        padding-top: 120px;
    }
    .hero_text_center h2 {
        font-size: 28px;
    }
    .hero_text_center p {
        font-size: 16px;
    }
}
</style>
    <section class="header_area">
        <div class="header_navbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="index.html">
                                <img src="{{ url('layout/images/logo_b_car.png') }}" style="width: 180px">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="page-scroll" href="#home">Página Inicial</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="page-scroll" href="#features">Feature</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">Sobre</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="page-scroll" href="#screenshot">Planos</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#pricing">Planos</a>
                                    </li>                                    
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#blog">Contato</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="{{ route('login') }}">Login</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- header navbar -->

        <div id="home" class="header_hero d-lg-flex align-items-center">
            <img class="shape shape-1" src="{{ url('layout/images/shape-1.svg') }}" alt="shape">
            <img class="shape shape-2" src="{{ url('layout/images/shape-2.svg') }}" alt="shape">
            <img class="shape shape-3" src="{{ url('layout/images/shape-3.svg') }}" alt="shape">
            
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="header_hero_content mt-45">
                            <h2 class="header_title wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.2s">Evite erros e aumente a produtividade</h2>
                            <p class="wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.6s">Integre todas as informações de desempenho dos seus veículos e melhore a produtividade da sua frota em um só lugar.</p>
                            <ul>
                                <li><a class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1s" href="#">Discover More</a></li>
                                <li><a class="main-btn main-btn-2 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1.4s" href="#">Download App</a></li>
                            </ul>
                        </div> <!-- header hero content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            <div class="header_image d-flex align-items-end">
                <div class="image wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="1.8s">
                    <img src="{{ url('layout/images/header_app.png') }}" alt="header App">
                    <img src="{{ url('layout/images/dots.svg') }}" alt="dots" class="dots">
                </div> <!-- image -->
            </div> <!-- header image -->
        </div> <!-- header hero -->

       
    </section>

    <!--====== HEADER PART ENDS ======-->
    
    <!--====== FEATURES PART START ======-->

    <section id="about" class="features_area pt-35 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="single_features mt-30 features_1 text-center wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
                    <div class="features_icon">
                        <i class="lni lni-car-alt"></i>
                    </div>
                    <div class="features_content">
                        <h4 class="features_title">Gestão de Veículos</h4>
                        <p>Controle total da sua frota em um só lugar.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="single_features mt-30 features_2 text-center wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">
                    <div class="features_icon">
                        <i class="lni lni-write"></i>
                    </div>
                    <div class="features_content">
                        <h4 class="features_title">Procurações</h4>
                        <p>Geração automatizada de procurações com agilidade e sem erros.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-8">
                <div class="single_features mt-30 features_3 text-center wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.6s">
                    <div class="features_icon">
                        <i class="lni lni-files"></i>
                    </div>
                    <div class="features_content">
                        <h4 class="features_title">Loja Virtual</h4>
                        <p>Plataforma para venda e gerenciamento dos seus veículos.</p>
                    </div>
                </div>
            </div>
        </div> 

        <div class="row justify-content-center">
    <div class="col-lg-4 col-md-6 col-sm-8">
        <div class="single_features mt-30 features_1 text-center wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
            <div class="features_icon">
                <i class="lni lni-write"></i> </div>
            <div class="features_content">
                <h4 class="features_title">Procurações Automatizadas</h4>
                <p>Evite erros na geração de procurações com processos automatizados.</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 col-sm-8">
        <div class="single_features mt-30 features_2 text-center wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">
            <div class="features_icon">
                <i class="lni lni-users"></i> </div>
            <div class="features_content">
                <h4 class="features_title">Gestão de Cadastros</h4>
                <p>Cadastros simples de clientes e veículos, facilitando o gerenciamento completo de todas as suas procurações.</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 col-sm-8">
    <div class="single_features mt-30 features_3 text-center wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.6s">
        <div class="features_icon">
            <i class="lni lni-save"></i> 
        </div>
        <div class="features_content">
            <h4 class="features_title">Relatórios em PDF</h4>
            <p>O sistema gera arquivos e relatórios em PDF personalizados para facilitar o manuseio, arquivamento e impressão.</p>
        </div>
    </div>
</div>
</div>

      </div> 
      </section>

{{-- 
    <section id="about" class="about_area pt-30 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-9">
                    <div class="about_image mt-50 wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
                        <img class="image" src="{{ url('layout/images/background_alcecar.png') }}">
                        <img class="dots" src="{{ url('layout/images/dots.svg') }}" alt="dots">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about_content mt-45 wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
                        <div class="section_title">
                            <h4 class="title">Discover New Experience!</h4>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sediam nonumy eirmod tempor invidunt ut labore et dolore malquyam erat, sed diam voluptua. At vero eos et accusam et justo doloes et ea rebum. Stet clita kasd gubergren, nod sea takmaa santus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sitdse ametr consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore.</p>
                        </div>
                        <a class="main-btn" href="#">Discover</a>
                        
                    </div>
                </div>
            </div>
        </div> 
    </section> --}}

    <!--====== ABOUT PART ENDS ======-->
    
    <!--====== APP FEATURES PART START ======-->

    <section id="app_features">

    </section>

    <!--====== APP FEATURES PART ENDS ======-->
    
    <!--====== VIDEO PART START ======-->

    <section id="video" class="video_area pt-80 pb-80" style="background-color: #f4f7f9;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section_title text-center">
                    <h4 class="title wow fadeInUp" data-wow-delay="0.2s">Pronto para digitalizar sua gestão?</h4>
                    <p class="wow fadeInUp" data-wow-delay="0.4s">
                        Junte-se a centenas de usuários que já automatizaram a geração de procurações e o gerenciamento de frotas. 
                        Simples, rápido e totalmente seguro.
                    </p>
                    <br>
                    <div class="wow fadeInUp" data-wow-delay="0.6s">
                        <a href="#cadastro" class="main-btn">Começar Agora Gratuitamente</a>
                    </div>
                </div> </div>
        </div> </div> </section>

<section id="screenshot">
    
</section>
    
    <!--====== PRICNG PART START ======-->
<section id="pricing" class="pricing_area mt-80 pt-75 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h4 class="title">Planos e Preços</h4>
                    <p>Escolha o plano ideal para a sua frota ou despachante e comece a automatizar seus processos hoje mesmo.</p>
                </div> </div>
        </div> 
        <div class="row justify-content-center">
    <div class="col-lg-5 col-md-8 col-sm-10">
        <div class="single_pricing text-center pricing_color_1 mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
            <div class="pricing_top_bar">
                <h5 class="pricing_title">Licença Standard</h5>
                <i class="lni lni-coffee-cup"></i>
                <span class="price">R$ 300</span>
            </div>
            <div class="pricing_list">
                <ul>
                    <li>Até 50 veículos</li>
                    <li>Sem limite de usuários</li>
                    <li>Emissão de Procurações</li>
                    <li>Emissão de Solicitação ATPVe</li>
                    <li>Gestão de Veículos</li>
                    <li>Website e Loja Virtual</li>
                    <li>Suporte Técnico 24/7</li>
                </ul>
            </div>
            <div class="pricing_btn">
                <a href="https://wa.me/555199047299?text=Olá!%20Gostaria%20de%20solicitar%20um%20teste%20do%20sistema." 
   target="_blank" 
   class="main-btn main-btn-2">
   Solicitar teste
</a>
            </div>
        </div>
    </div>

    <div class="col-lg-5 col-md-8 col-sm-10">
        <div class="single_pricing text-center pricing_active pricing_color_2 mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.5s">
            <div class="pricing_top_bar">
                <h5 class="pricing_title">Licença Full</h5>
                <i class="lni lni-crown"></i>
                <span class="price">R$ 500</span>
            </div>
            <div class="pricing_list">
                <ul>
                  <li>Sem limite de veículos </li>
                    <li>Sem limite de usuários</li>
                    <li>Emissão de Procurações</li>
                    <li>Emissão de Solicitação ATPVe</li>
                    <li>Gestão de Veículos</li>
                    <li>Website e Loja Virtual</li>
                    <li>Suporte Técnico 24/7</li>
                </ul>
            </div>
            <div class="pricing_btn">
               <a href="https://wa.me/555199047299?text=Olá!%20Gostaria%20de%20solicitar%20um%20teste%20do%20sistema." 
   target="_blank" 
   class="main-btn main-btn-2">
   Solicitar teste
</a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ajuste para centralizar melhor os dois planos na tela */
    @media (min-width: 992px) {
        .col-lg-5 {
            flex: 0 0 40%;
            max-width: 40%;
        }
    }
    
    /* Remove o estilo de 'por mês' já que é venda de licença */
    .pricing_top_bar .price {
        font-size: 40px;
        display: block;
        margin-top: 10px;
    }
</style>
      </div> 
    </section>

<style>
    /* Pequeno ajuste para a duração do preço não ficar colada */
    .duration {
        font-size: 14px;
        color: #666;
        display: inline-block;
        margin-left: 2px;
    }
</style>

    <!--====== PRICNG PART ENDS ======-->
    
    <!--====== DOWNLOAD APP PART START ======-->
{{-- 
    <section id="download" class="download_app_area pt-80 mb-80">
        <div class="container">
            <div class="download_app">
                <div class="download_shape">
                    <img src="{{ url('layout/images/shape-5.svg') }}" alt="shape">
                </div>
                <div class="download_shape_2">
                    <img src="{{ url('layout/images/shape-6.png') }}" alt="shape">
                </div>
                <div class="download_app_content">
                    <h3 class="download_title">Download The App</h3>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sediam nonumy eirmod.</p>
                    <ul>
                        <li>
                            <a class="d-flex align-items-center" href="#">
                                <span class="icon">
                                    <i class="lni lni-play-store"></i>
                                </span>
                                <span class="content media-body">
                                    <h6 class="title">Play Store</h6>
                                    <p>Download Now</p>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="#">
                                <span class="icon">
                                    <i class="lni lni-apple"></i>
                                </span>
                                <span class="content">
                                    <h6 class="title">App Store</h6>
                                    <p>Download Now</p>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>  <!-- download app content -->
            </div> <!-- download app -->
        </div> <!-- container -->
        <div class="download_app_image d-none d-lg-flex align-items-end">
            <div class="image wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
                <img src="{{ url('assets/images/download.png') }}" alt="download">
            </div> <!-- image -->
        </div> <!-- download app image -->
    </section> --}}

    <!--====== DOWNLOAD APP PART ENDS ======-->
    
    <!--====== BLOG PART START ======-->
<section id="blog" class="blog_area pt-80 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h4 class="title">Destaques do Sistema</h4>
                    <p>Conheça as tecnologias e diferenciais que fazem da nossa plataforma a melhor escolha para sua gestão automotiva.</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-8">
                <div class="single_blog blog_1 mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
                    <div class="blog_image">
                        <img src="{{ url('layout/images/blog-1.jpg') }}" alt="Segurança de Dados">
                    </div>
                    <div class="blog_content">
                        <div class="blog_meta d-flex justify-content-between">
                            <div class="meta_date">
                                <span>Segurança Avançada</span>
                            </div>
                        </div>
                        <h4 class="blog_title"><a href="#">Seus dados e documentos protegidos com criptografia de ponta.</a></h4>
                        <p class="text">Garantimos a integridade de todas as procurações e cadastros realizados no sistema.</p>
                        {{-- <a href="#" class="main-btn">Saiba Mais</a> --}}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-8">
                <div class="single_blog blog_2 mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.5s">
                    <div class="blog_image">
                        <img src="{{ url('layout/images/blog-2.jpg') }}" alt="Interface Intuitiva">
                    </div>
                    <div class="blog_content">
                        <div class="blog_meta d-flex justify-content-between">
                            <div class="meta_date">
                                <span>Interface Amigável</span>
                            </div>
                        </div>
                        <h4 class="blog_title"><a href="#">Design focado na experiência do usuário e agilidade no dia a dia.</a></h4>
                        <p class="text">Interface limpa e intuitiva para que você gere documentos em poucos cliques.</p>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-8">
                <div class="single_blog blog_3 mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.8s">
                    <div class="blog_image">
                        <img src="{{ url('layout/images/blog-3.jpg') }}" alt="Suporte e Nuvem">
                    </div>
                    <div class="blog_content">
                        <div class="blog_meta d-flex justify-content-between">
                            <div class="meta_date">
                                <span>Tecnologia em Nuvem</span>
                            </div>
                        </div>
                        <h4 class="blog_title"><a href="#">Acesse sua gestão de qualquer lugar, a qualquer momento.</a></h4>
                        <p class="text">Mobilidade total para acessar relatórios e emitir ATPVe direto do seu dispositivo.</p>
                        
                    </div>
                </div>
            </div> 
        </div>
    </div>
</section>

<style>
    /* Ajuste para que as imagens do blog fiquem padronizadas */
    .blog_image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }
    .blog_content .text {
        margin-top: 15px;
        margin-bottom: 20px;
        font-size: 15px;
        color: #666;
        line-height: 1.5;
    }
    
    .meta_date span {
        font-weight: 600;
        color: #fe8464;
        text-transform: uppercase;
        font-size: 12px;
    }
</style>
<section id="footer" class="footer_area pt-75 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="footer_subscribe text-center">
                    <h3 class="subscribe_title">Fale Conosco pelo WhatsApp</h3>
                    <p class="mb-30">Preencha os dados abaixo para iniciar uma conversa agora mesmo e tirar suas dúvidas sobre o sistema.</p>
                    
                    <div class="custom_whatsapp_form">
                        <form id="whatsappForm" onsubmit="sendToWhatsApp(event)">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" id="name" placeholder="Seu Nome..." required class="form_input">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select id="subject" required class="form_input">
                                        <option value="" disabled selected>Assunto...</option>
                                        <option value="Orçamento">Solicitar Orçamento</option>
                                        <option value="Suporte">Suporte Técnico</option>
                                        <option value="Demonstração">Agendar Demonstração</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-10">
                                <div class="col-md-8">
                                    <button type="submit" class="main-btn btn-whatsapp">
                                        <i class="lni lni-whatsapp"></i> Iniciar Conversa
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                
                
                <div class="footer_copyright text-center mt-55">
                    <p>Copyright &copy; 2026. Todos os direitos reservados. </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Resetando conflitos do template */
    .custom_whatsapp_form {
        position: relative;
        max-width: 700px;
        margin: 0 auto;
        padding: 20px;
    }

    .form_input {
        width: 100% !important;
        height: 55px !important;
        padding: 0 25px !important;
        border-radius: 50px !important;
        border: 2px solid rgba(255,255,255,0.2) !important;
        outline: none !important;
        background: white !important;
        color: #333 !important;
        position: relative !important; /* Força sair do absolute se houver */
    }

    /* Estilo do Botão */
    .btn-whatsapp {
        background-color: #25D366 !important;
        border-color: #25D366 !important;
        color: #fff !important;
        width: 100% !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .btn-whatsapp:hover {
        background-color: #128C7E !important;
        transform: translateY(-3px);
    }

    /* Redes Sociais */
    .footer_social ul {
        display: flex;
        justify-content: center;
        gap: 20px;
        list-style: none;
        padding: 0;
    }
    
    .footer_social ul li a {
        font-size: 24px;
        color: #fff; /* Ajustado para branco para aparecer no fundo roxo */
        opacity: 0.8;
    }

    .footer_social ul li a:hover {
        opacity: 1;
        color: #25D366;
    }

    .footer_copyright p {
        color: #fff;
        opacity: 0.7;
    }
</style>

<script>
function sendToWhatsApp(event) {
    event.preventDefault();
    const phoneNumber = "555199047299"; // COLOQUE SEU NÚMERO AQUI
    const name = document.getElementById('name').value;
    const subject = document.getElementById('subject').value;
    const message = `Olá! Meu nome é ${name}. Gostaria de falar sobre: ${subject}.`;
    window.open(`https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`, '_blank');
}
</script>


    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>
    <script src="{{ url('layout/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ url('layout/js/vendor/modernizr-3.7.1.min.js') }}"></script>
<script src="{{ url('layout/js/popper.min.js') }}"></script>
<script src="{{ url('layout/js/bootstrap.4.5.2.min.js') }}"></script>
<script src="{{ url('layout/js/jquery.easing.min.js') }}"></script>
<script src="{{ url('layout/js/scrolling-nav.js') }}"></script>
<script src="{{ url('layout/js/wow.min.js') }}"></script>
<script src="{{ url('layout/js/main.js') }}"></script>
    
</body>

</html>
