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
    <meta property="og:image" content="{{ url('layout_site/images/logo_carro.png') }}">

    <meta property="twitter:card" content="summary_large_image"> 
    <meta property="twitter:url" content="https://alcecar.com.br/">
    <meta property="twitter:title" content="Gestão de Veículos e Automação de Procurações">
    <meta property="twitter:description" content="Otimize sua produtividade com nosso sistema de gestão automotiva.">
    <meta property="twitter:image" content="{{ url('layout_site/images/logo_carro.png') }}">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ url('layout_site/images/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ url('layout_site/css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('layout_site/css/LineIcons.2.0.css') }}">
    <link rel="stylesheet" href="{{ url('layout_site/css/bootstrap.4.5.2.min.css') }}">
    <link rel="stylesheet" href="{{ url('layout_site/css/default.css') }}">
    <link rel="stylesheet" href="{{ url('layout_site/css/style.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-02FMMXT79W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-02FMMXT79W');
</script>
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
                            <a class="navbar-brand" href="{{ route('site.index') }}">
                                <img src="{{ url('layout_site/images/logo_texto.png') }}" style="width: 180px">
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
                                        <a class="page-scroll" href="#sobre">Sobre</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="page-scroll" href="#loja">Loja virtual</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#planos">Planos</a>
                                    </li>                                    
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#contato">Contato</a>
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
            <img class="shape shape-1" src="{{ url('layout_site/images/shape-1.svg') }}" alt="shape">
            <img class="shape shape-2" src="{{ url('layout_site/images/shape-2.svg') }}" alt="shape">
            <img class="shape shape-3" src="{{ url('layout_site/images/shape-3.svg') }}" alt="shape">
            
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="header_hero_content mt-45">
                            <h2 class="header_title wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.2s">Inteligência de Dados e Gestão de Veículos</h2>
<p class="wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.6s">Centralize a documentação, o desempenho e o controle técnico da sua frota com automação e precisão em um só lugar.</p>
                            <ul>
                                <li><a class="main-btn wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="1s" href="{{ route('login') }}">Teste agora</a></li>
                                <li>
    <a class="main-btn main-btn-2 wow fadeInUp"
       data-wow-duration="1.3s"
       data-wow-delay="1.4s"
       href="https://wa.me/5551999047299"
       target="_blank"
       rel="noopener">
        Chame no WhatsApp
    </a>
</li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header_image d-flex align-items-end">
                <div class="image wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="1.8s">
                    <img src="{{ url('layout_site/images/header_app.png') }}" alt="header App">
                    <img src="{{ url('layout_site/images/dots.svg') }}" alt="dots" class="dots">
                </div>
            </div>
        </div>

       
    </section>

    <!--====== HEADER PART ENDS ======-->
    
    <!--====== FEATURES PART START ======-->

    <section id="sobre" class="features_area pt-35 pb-80">
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
                        <i class="lni lni-search"></i> </div>
                    <div class="features_content">
                        <h4 class="features_title">Extração de Dados</h4>
                        <p>Leitura inteligente de documentos em PDF.</p>
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
    <section id="loja" class="about_area pt-30 pb-80">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-9">
                <div class="about_image mt-50 wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
                    <img class="image" src="{{ url('layout_site/images/header_app_2.png') }}">
                    <img class="dots" src="{{ url('layout_site/images/dots.svg') }}" alt="dots">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="about_content mt-45 wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
                    <div class="section_title">
                        <h4 class="title">Tenha sua Loja Virtual e Venda Mais</h4>

                        <p>
                            Com o <strong>Alcecar</strong>, você pode criar sua
                            <strong>loja virtual</strong> e dar mais visibilidade aos seus produtos
                            e serviços. O sistema foi desenvolvido para aumentar sua
                            <strong>exposição online</strong> e facilitar a conexão com novos clientes.
                        </p>

                        <p>
                            Além disso, você conta com ferramentas para
                            <strong>gestão de anúncios</strong>, controle de campanhas,
                            acompanhamento de resultados e otimização do desempenho,
                            tudo em um único lugar, de forma simples e eficiente.
                        </p>
                    </div>

                    <a class="main-btn" href="#contato">Saiba Mais</a>
                </div>
            </div>
        </div>
    </div> 
</section> --}}

    

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
    

<section id="planos" class="pricing_area mt-80 pt-75 pb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h4 class="title">Planos e Preços</h4>
                    <p>Escolha a licença ideal para o seu negócio. Gestão profissional de estoque, multas e documentos para todos os tamanhos de revendas.</p>
                </div>
            </div>
        </div> 
        
        <div class="row justify-content-center">
            
            <div class="col-lg-4 col-md-8 col-sm-10">
                <div class="single_pricing text-center mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.2s">
                    <div class="pricing_top_bar">
                        <h5 class="pricing_title">Plano Start</h5>
                        <i class="lni lni-user"></i> <span class="price">R$ 29,90</span>
                        <p class="mt-2">Ideal para autônomos</p>
                    </div>
                    <div class="pricing_list">
                        <ul>
                            <li><strong>1 Usuário (Administrador)</strong></li>
                            <li>Gestão de Veículos</li>
                            <li>Emissão de Procurações</li>
                            <li style="text-decoration: line-through; color: #aaa;">Emissão de Solicitações ATPVe</li>
                            <li style="text-decoration: line-through; color: #aaa;">Emissão de Comunicação de venda</li>
                            <li style="text-decoration: line-through; color: #aaa;">Tabela FIPE Integrada</li>
                            <li>Suporte via WhatsApp</li>
                        </ul>
                    </div>
                    <div class="pricing_btn">
                        <a href="{{ route('register') }}" target="_blank" class="main-btn main-btn-2">Teste grátis</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-8 col-sm-10">
                <div class="single_pricing text-center pricing_active pricing_color_1 mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.4s">
                    <div class="pricing_top_bar">
                        <h5 class="pricing_title">Plano Standard</h5>
                        <i class="lni lni-layers"></i> <span class="price">R$ 49,90</span>
                        <p class="mt-2">Ideal para revendas</p>
                    </div>
                    <div class="pricing_list">
                        <ul>
                            <li><strong>Até 2 Vendedores</strong></li>
                            <li>Gestão de Veículos</li>
                            <li>Emissão de Procurações</li>
                            <li>Emissão de Solicitações ATPVe</li>
                            <li>Emissão de Comunicação de venda</li>
                            <li style="text-decoration: line-through; color: #aaa;">Tabela FIPE Integrada</li>
                            <li>Suporte via WhatsApp</li>
                        </ul>
                    </div>
                    <div class="pricing_btn">
                        <a href="{{ route('register') }}" class="main-btn main-btn-2">Teste grátis</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-8 col-sm-10">
                <div class="single_pricing text-center pricing_active pricing_color_2 mt-30 wow fadeInUp" data-wow-duration="1.3s" data-wow-delay="0.6s">
                    <div class="pricing_top_bar">
                        <h5 class="pricing_title">Plano Pro</h5>
                        <i class="lni lni-crown"></i>
                        <span class="price">R$ 69,90</span>
                        <p class="mt-2">Ideal para revendas</p>
                    </div>
                    <div class="pricing_list">
                        <ul>
                            <li><strong>Vendedores Ilimitados</strong></li>
                            <li>Gestão de Veículos</li>
                            <li>Emissão de Procurações</li>
                            <li>Emissão de Solicitações ATPVe</li>
                            <li>Emissão de Comunicação de venda</li>
                            <li>Tabela FIPE Integrada</li>
                            <li>Suporte Prioritário</li>
                        </ul>
                    </div>
                    <div class="pricing_btn">
                        <a href="{{ route('register') }}" class="main-btn main-btn-2">Teste grátis</a>
                    </div>
                </div>
            </div>

        </div>
    </div> 
</section>

<style>
    @media (min-width: 992px) {
        .col-lg-5 {
            flex: 0 0 40%;
            max-width: 40%;
        }
    }
    
    .pricing_top_bar .price {
        font-size: 40px;
        display: block;
        margin-top: 10px;
        font-weight: 700;
    }

    /* Estilo para destacar o item de Loja Virtual no plano Full */
    .pricing_active .pricing_list ul li strong {
        color: #ff9f43; /* Ou a cor de destaque do seu tema */
    }
</style>

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

    <section id="download" class="download_app_area pt-80 mb-80">
    <div class="container">
        <div class="download_app">
            <div class="download_shape">
                <img src="{{ url('layout_site/images/shape-5.svg') }}" alt="shape">
            </div>
            <div class="download_shape_2">
                <img src="{{ url('layout_site/images/shape-6.png') }}" alt="shape">
            </div>

            <div class="download_app_content">
                <h3 class="download_title">Documentos em PDF</h3>

<p>
    O <strong>sistema</strong> permite criar, personalizar e gerar
    <strong>procurações em PDF</strong> de forma rápida e segura.
    O sistema automatiza o preenchimento dos dados, reduz erros manuais
    e garante documentos padronizados, prontos para impressão ou envio digital.
</p>


                <!-- BOTÕES LADO A LADO -->
                <ul class="d-flex gap-3 flex-wrap">
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('login') }}">
                            <span class="icon">
                                <i class="lni lni-rocket"></i>
                            </span>
                            <span class="content media-body">
                                <h6 class="title">Testar Agora</h6>
                                <p>Acesso rápido ao sistema</p>
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="d-flex align-items-center"
                        href="https://wa.me/5551999047299"
                        target="_blank"
                        rel="noopener">
                            <span class="icon">
                                <i class="lni lni-whatsapp"></i>
                            </span>
                            <span class="content">
                                <h6 class="title">Solicitar Demonstração</h6>
                                <p>Fale conosco pelo WhatsApp</p>
                            </span>
                        </a>
                    </li>

                </ul>
                <!-- /BOTÕES -->
            </div>
        </div>
    </div>

    <div class="download_app_image d-none d-lg-flex align-items-end">
        <div class="image wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
            <img src="{{ url('layout_site/images/header_app_3.png') }}" alt="Proconline">
        </div>
    </div>
</section>


<section class="section pt-80 pb-80 bg-light" id="processos">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8 text-center mx-auto">
                <span class="text-primary text-uppercase fw-bold mb-3 d-block wow fadeInUp" data-wow-delay="0.1s">Agilidade Inteligente</span>
                <h2 class="title wow fadeInUp" data-wow-delay="0.2s">Como funciona o Cadastro Automático</h2>
                <p class="text-muted wow fadeInUp" data-wow-delay="0.3s">
                    Esqueça o preenchimento manual demorado. Nossa tecnologia de leitura inteligente faz o trabalho pesado para você em três etapas simples:
                </p>
            </div>
        </div>

        <div class="row g-md-5 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative wow fadeInUp" data-wow-delay="0.2s">
                    <span class="step-number rounded-circle text-center fw-bold mb-4 mx-auto">1</span>
                    <div>
                        <h3 class="fs-5 mb-3">Upload do PDF</h3>
                        <p class="text-muted">Você envia o documento do veículo (CRV/ATPV-e) em formato PDF diretamente na nossa plataforma.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="step-card text-center h-100 d-flex flex-column justify-content-start position-relative wow fadeInUp" data-wow-delay="0.5s">
                    <span class="step-number rounded-circle text-center fw-bold mb-4 mx-auto">2</span>
                    <h3 class="fs-5 mb-3">Processamento</h3>
                    <p class="text-muted">Aguarde alguns segundos enquanto nossa inteligência extrai Renavam, Placa, Chassi e todos os dados técnicos sem erros.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="step-card last text-center h-100 d-flex flex-column justify-content-start position-relative wow fadeInUp" data-wow-delay="0.8s">
                    <span class="step-number rounded-circle text-center fw-bold mb-4 mx-auto">3</span>
                    <div>
                        <h3 class="fs-5 mb-3">Pronto!</h3>
                        <p class="text-muted">O cadastro é concluído instantaneamente. Dados validados, organizados e prontos para gerar suas procurações.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .step-number {
        width: 50px;
        height: 50px;
        line-height: 50px;
        background-color: #727cf5; /* Cor primária do Alcecar */
        color: #fff;
        font-size: 20px;
        display: block;
        box-shadow: 0 4px 10px rgba(114, 124, 245, 0.3);
    }
    .step-card {
        padding: 20px;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    .step-card:hover {
        transform: translateY(-5px);
    }
    .step-card p {
        font-size: 14px;
        line-height: 1.6;
    }
    /* Estilo para as linhas conectoras (opcional se não tiver o SVG) */
    @media (min-width: 992px) {
        .step-card:not(.last):after {
            content: "→";
            position: absolute;
            right: -10%;
            top: 45px;
            font-size: 30px;
            color: #727cf5;
            opacity: 0.3;
        }
    }
</style>

<section id="contato" class="blog_area pt-80 pb-80">
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
                        <img src="{{ url('layout_site/images/blog-1.jpg') }}" alt="Segurança de Dados">
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
                        <img src="{{ url('layout_site/images/blog-2.jpg') }}" alt="Interface Intuitiva">
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
                        <img src="{{ url('layout_site/images/blog-3.jpg') }}" alt="Suporte e Nuvem">
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
    <script src="{{ url('layout_site/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ url('layout_site/js/vendor/modernizr-3.7.1.min.js') }}"></script>
<script src="{{ url('layout_site/js/popper.min.js') }}"></script>
<script src="{{ url('layout_site/js/bootstrap.4.5.2.min.js') }}"></script>
<script src="{{ url('layout_site/js/jquery.easing.min.js') }}"></script>
<script src="{{ url('layout_site/js/scrolling-nav.js') }}"></script>
<script src="{{ url('layout_site/js/wow.min.js') }}"></script>
<script src="{{ url('layout_site/js/main.js') }}"></script>
    
</body>

</html>
