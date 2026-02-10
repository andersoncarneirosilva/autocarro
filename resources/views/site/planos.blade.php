<!doctype html>
<html class="no-js" lang="pt-BR">

<head>
    <meta charset="utf-8">
    
    <title>Planos Alcecar | Gestão de Veículos e Automação de Procurações</title>
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

    <style>
.hero_text_center {
    text-align: center;
    position: relative;
    z-index: 5;
    padding: 0 15px; 
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
    max-width: 850px; 
    margin: 0 auto;
}

.hero_image_main {
    margin-top: 20px;
    text-align: center;
}

.hero_image_main img {
    max-width: 100%;
    height: auto;
    filter: drop-shadow(0px 20px 40px rgba(0,0,0,0.3));
}

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
                                    <li class="nav-item">
                                        <a class="page-scroll" href="{{ route('site.index') }}">Página Inicial</a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="page-scroll" href="{{ route('site.planos') }}">Planos</a>
                                    </li>                                    
                                    <li class="nav-item">
                                        <a class="page-scroll" href="{{ route('login') }}">Login</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div> 
        </div> 

        

       
    </section>

    
    

<section id="planos" class="pricing_area mt-80 pt-75 pb-80">
    <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h4 class="title">Planos e Preços</h4>
                    <p>Escolha a licença ideal para o seu negócio. Gestão profissional de estoque, multas e documentos para todos os tamanhos de revendas.</p>
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

    .pricing_active .pricing_list ul li strong {
        color: #ff9f43;
    }
</style>

<style>
    .duration {
        font-size: 14px;
        color: #666;
        display: inline-block;
        margin-left: 2px;
    }
</style>

  

<section id="contato" class="blog_area pt-80 pb-80">
    <div class="container">
         
        
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
        position: relative !important;
    }
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
        color: #fff;
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
    const phoneNumber = "555199047299";
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
