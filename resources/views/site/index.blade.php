
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ProcOnline</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <!-- NAVBAR START -->
    <nav class="navbar navbar-expand-lg py-lg-3 navbar-dark">
        <div class="container">

            <!-- logo -->
            <a href="index.html" class="navbar-brand me-lg-5">
                <img src="assets/images/logo.png" alt="logo" class="logo-dark" height="22" />
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <!-- menus -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- right menu -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-0">
                        <a href="{{ route('login') }}" class="nav-link d-lg-none">Area do cliente</a>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light rounded-pill d-none d-lg-inline-flex">
                            <i class="mdi mdi-account me-2"></i> Area do cliente
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- START HERO -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-4 mt-3 lh-base">Gestão Simplificada e Controle Total em um só lugar.</h2>

                        <p class="mb-4 font-16 text-white-50">Nosso sistema de procurações foi desenvolvido para 
                            oferecer uma solução completa e intuitiva. Com recursos modernos, interface amigável e 
                            ferramentas práticas, você pode criar, gerenciar e organizar procurações de maneira ágil e segura. 
                            Tudo que você precisa para centralizar e otimizar seus processos está aqui!
                        </p>
                        
                        <a href="{{ route('register') }}" 
                        class="btn btn-lg font-16 btn-success">Teste grátis <i class="mdht ms-1"></i></a>
                        {{-- <a href="" target="_blank" class="btn btn-lg font-16 btn-info">Check Demos</a> --}}
                    </div>
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="assets/images/svg/startup.svg" alt="" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END HERO -->

    <!-- START SERVICES -->
    <section class="py-5">
        <div class="container">
            <div class="row py-4">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mt-0"><i class="mdi mdi-infinity"></i></h1>
                        <h3>Confira as características, benefícios</span> e vantagens</h3>
                        <p class="text-muted mt-2">Sistema de fácil utilização sem a 
                            necessidade de instalações.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-desktop text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Layout responsivo</h4>
                        <p class="text-muted mt-2 mb-0">Um layout responsivo garante que seu site se adapte perfeitamente a qualquer 
                            dispositivo, proporcionando uma experiência otimizada para todos os usuários.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-vector-square text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Agilidade</h4>
                        <p class="text-muted mt-2 mb-0">Agilidade na geração de documentos economiza tempo e 
                            aumenta a produtividade, garantindo entregas rápidas e eficientes.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-file-times-alt text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Evite erros</h4>
                        <p class="text-muted mt-2 mb-0">Evite erros na geração de procurações com processos automatizados e maior precisão.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-users-alt text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Cadastros</h4>
                        <p class="text-muted mt-2 mb-0">Cadastros simples de clientes e veículos, facilitando o gerencimento
                            de procurações.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-file-plus-alt text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Procuração avulsa</h4>
                        <p class="text-muted mt-2 mb-0">Gere uma procuração avulsa caso o cliente não tenha o documento em pdf.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-2 p-sm-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-file-copy-alt text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Arquivos em pdf</h4>
                        <p class="text-muted mt-2 mb-0">O sistema gera arquivos e relatórios em pdf para facilitar
                             o manuseio e impressão.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- END SERVICES -->

    <!-- START FEATURES 1 -->
    {{-- <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3>Flexible <span class="text-primary">Layouts</span></h3>
                        <p class="text-muted mt-2">There are three different layout options available to cater need for
                            any <br /> modern web
                            application.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-lg-4 col-md-6">
                    <div class="demo-box text-center mt-3">
                        <img src="assets/images/layouts/layout-1.png" alt="demo-img" class="img-fluid shadow-sm rounded">
                        <h5 class="mt-3 f-17">Vertical Layout</h5>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="demo-box text-center mt-3">
                        <img src="assets/images/layouts/layout-2.png" alt="demo-img" class="img-fluid shadow-sm rounded">
                        <h5 class="mt-3 f-17">Horizontal Layout</h5>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="demo-box text-center mt-3">
                        <img src="assets/images/layouts/layout-3.png" alt="demo-img" class="img-fluid shadow-sm rounded">
                        <h5 class="mt-3 f-17">Detached Layout</h5>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="demo-box text-center mt-3">
                        <img src="assets/images/layouts/layout-5.png" alt="demo-img" class="img-fluid shadow-sm rounded">
                        <h5 class="mt-3 f-17">Light Sidenav Layout</h5>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="demo-box text-center mt-3">
                        <img src="assets/images/layouts/layout-6.png" alt="demo-img" class="img-fluid shadow-sm rounded">
                        <h5 class="mt-3 f-17">Boxed Layout</h5>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="demo-box text-center mt-3">
                        <img src="assets/images/layouts/layout-4.png" alt="demo-img" class="img-fluid shadow-sm rounded">
                        <h5 class="mt-3 f-17">Semi Dark Layout</h5>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- END FEATURES 1 -->

    <!-- START FEATURES 2 -->
    {{-- <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mt-0"><i class="mdi mdi-heart-multiple-outline"></i></h1>
                        <h3>Features you'll <span class="text-danger">love</span></h3>
                        <p class="text-muted mt-2">Hyper comes with next generation ui design and have multiple benefits
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mt-2 py-5 align-items-center">
                <div class="col-lg-5 col-md-6">
                    <img src="assets/images/svg/features-1.svg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 offset-md-1 col-md-5">
                    <h3 class="fw-normal">Inbuilt applications and pages</h3>
                    <p class="text-muted mt-3">Hyper comes with a variety of ready-to-use applications and pages that help to speed up the development</p>

                    <div class="mt-4">
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-primary"></i> Projects & Tasks</p>
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-primary"></i> Ecommerce Application Pages</p>
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-primary"></i> Profile, pricing, invoice</p>
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-primary"></i> Login, signup, forget password</p>
                    </div>

                    <a href="" class="btn btn-primary rounded-pill mt-3">Read More <i class="mdi mdi-arrow-right ms-1"></i></a>

                </div>
            </div>

            <div class="row pb-3 pt-5 align-items-center">
                <div class="col-lg-6 col-md-5">
                    <h3 class="fw-normal">Simply beautiful design</h3>
                    <p class="text-muted mt-3">The simplest and fastest way to build dashboard or admin panel. Hyper is built using the latest tech and tools and provide an easy way to customize anything, including an overall color schemes, layout, etc.</p>

                    <div class="mt-4">
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-success"></i> Built with latest Bootstrap</p>
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-success"></i> Extensive use of SCSS variables</p>
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-success"></i> Well documented and structured code</p>
                        <p class="text-muted"><i class="mdi mdi-circle-medium text-success"></i> Detailed Documentation</p>
                    </div>

                    <a href="" class="btn btn-success rounded-pill mt-3">Read More <i class="mdi mdi-arrow-right ms-1"></i></a>

                </div>
                <div class="col-lg-5 col-md-6 offset-md-1">
                    <img src="assets/images/svg/features-2.svg" class="img-fluid" alt="">
                </div>
            </div>

        </div>
    </section> --}}
    <!-- END FEATURES 2 -->

    <!-- START PRICING -->
    <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mt-0"><i class="mdi mdi-tag-multiple"></i></h1>
                        <h3>Escolha do <span class="text-primary">Plano</span></h3>
                        <p class="text-muted mt-2">Você tem a opção de utilizar o sistema sem limites ou por créditos.
                            <br>Escolha a melhor forma para usar no seu negócio.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-pricing">
                            {{-- <div class="card-body text-center">
                                <p class="card-pricing-plan-name fw-bold text-uppercase">Básico</p>
                                <i class="card-pricing-icon ri-user-line text-primary"></i>
                                <h2 class="card-pricing-price">R$50 <span>/ mês</span></h2>
                                <ul class="card-pricing-features">
                                    <li>Gerar procuração</li>
                                    <li>Gerar solicitação ATPVe</li>
                                    <li>1 GB de armazenamento</li>
                                    <li>Suporte dedicado</li>
                                </ul>
                                <button class="btn btn-primary mt-4 mb-2 rounded-pill">Escolher plano</button>
                            </div> --}}
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="card card-pricing">
                            <div class="card-body text-center">
                                <p class="card-pricing-plan-name fw-bold text-uppercase">Intermediário</p>
                                <i class="card-pricing-icon ri-briefcase-line text-success"></i>
                                <h2 class="card-pricing-price">R$50 <span>/ mês</span></h2>
                        <ul class="card-pricing-features">
                            <li>Gerar procuração</li>
                            <li>Gerar solicitação ATPVe</li>
                            <li>1 GB de armazenamento</li>
                            <li>Suporte dedicado</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-success mt-4 mb-2 rounded-pill">Escolher plano</a>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="card card-pricing">
                            {{-- <div class="card-body text-center">
                                <p class="card-pricing-plan-name fw-bold text-uppercase">Avançado</p>
                                <i class="card-pricing-icon ri-shield-star-line text-danger"></i>
                                <h2 class="card-pricing-price">R$400 <span>/ mês</span></h2>
                                <ul class="card-pricing-features">
                                    <li>Documentos ilimitados</li>
                                    <li>5 GB de armazenamento</li>
                                    <li>1 usuário</li>
                                    <li>Suporte dedicado</li>
                                </ul>
                                <button class="btn btn-danger mt-4 mb-2 rounded-pill">Escolher plano</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                
                    <!-- end Pricing_card -->
                </div>
                <!-- end col -->

            </div>

        </div>
    </section>
    <!-- END PRICING -->

    <!-- START FAQ -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mt-0"><i class="mdi mdi-frequently-asked-questions"></i></h1>
                        <h3>Perguntas <span class="text-primary">frequentes</span></h3>
                        <p class="text-muted mt-2">Aqui estão alguns dos tipos básicos de perguntas para nossos clientes.
                            <br>Para mais informações entre em contato conosco.
                        </p>

                        <button type="button" class="btn btn-success btn-sm mt-2">
                            <i class="mdi mdi-whatsapp me-1"></i>
                            <a href="https://api.whatsapp.com/send/?phone=51999047299&text&type=phone_number&app_absent=0" 
                                style="text-decoration: none; color: white;" 
                                target="_blank">(51)99904.7299
                            </a>
                        </button>
                        
                        <button type="button" class="btn btn-info btn-sm mt-2 ms-1"><i class="mdi mdi-email me-1"></i> Enviar email</button>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-5 offset-lg-1">
                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">Posso testar o sistema sem pagar?</h4>
                        <p class="faq-answer mb-4 pb-1 text-muted">Sim, o período de testes é 100% gratuíto, 
                            Você tem um limite de 10 procurações para gerar, não precisando cadastrar
                            qualquer forma de pagamento antecipado.
                        </p>
                    </div>

                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">Como obtenho ajuda para o sistema?</h4>
                        <p class="faq-answer mb-4 pb-1 text-muted">Pode entrar em contato diretamente com nossa equipe através do WhatsApp para obter uma resposta rápida.</p>
                    </div>

                </div>
                <!--/col-lg-5 -->

                <div class="col-lg-5">
                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">Como faço para testar o ProcOnline?</h4>
                        <p class="faq-answer mb-4 pb-1 text-muted">Para testar, basta entrar em contato  <a href="https://api.whatsapp.com/send/?phone=51999047299&text&type=phone_number&app_absent=0" target="_blank"">clicando aqui</a> e solicitar um teste gratuíto via WhatsApp.</p>
                    </div>

                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">O sistema gera procurações automaticamente?</h4>
                        <p class="faq-answer mb-4 pb-1 text-muted">Sim, após cadastrar o veículo do cliente, 
                            <br>é gerado uma procuração preenchida automaticamente, evitando erros na digitação. 
                        </p>
                    </div>

                </div>
                <!--/col-lg-5-->
            </div>
            <!-- end row -->

        </div> <!-- end container-->
    </section>
    <!-- END FAQ -->


    <!-- START CONTACT -->
    <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3>Entre em <span class="text-primary">Contato</span></h3>
                        <p class="text-muted mt-2">Por favor preencha o seguinte formulário e entraremos em contato com você em breve.
                            <br>Para mais informações entre em contato conosco.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mt-3">
                <div class="col-md-4">
                    <p class="text-muted"><span class="fw-bold">Suporte 24/7:</span><br> <span class="d-block mt-1">51 99904.7299</span></p>
                    <p class="text-muted mt-4"><span class="fw-bold">Email:</span><br> <span class="d-block mt-1">suporte@proconline.com.br</span></p>
                    <p class="text-muted mt-4"><span class="fw-bold">Atendimento:</span><br> <span class="d-block mt-1">Seg. a Sex. - 9:00AM as 6:00PM</span></p>
                </div>

                <div class="col-md-7">
                    @if(session('alert'))
    <script>
        Swal.fire({
            icon: '{{ session("alert.type") }}',
            title: '{{ session("alert.message") }}',
            html: '<p>Entraremos em contato assim que possível.</p>',  // Subtítulo adicional
            timer: {{ session("alert.autoClose") }},
            showConfirmButton: true,  // Habilita o botão "OK"
            confirmButtonText: 'OK',  // Texto do botão "OK"
            timerProgressBar: true
        });
    </script>
@endif

                


<form action="{{ route('contato.enviar') }}" method="POST">
    @csrf
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="mb-2">
                <label for="fullname" class="form-label">Nome</label>
                <input class="form-control form-control-light py-2" type="text" id="fullname" name="nome" placeholder="Seu nome...">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mb-2">
                <label for="emailaddress" class="form-label">Email</label>
                <input class="form-control form-control-light py-2" type="email" id="emailaddress" name="email" placeholder="Seu melhor email..." required>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-lg-12">
            <div class="mb-2">
                <label for="comments" class="form-label">Mensagem</label>
                <textarea id="comments" rows="4" class="form-control form-control-light" name="mensagem" placeholder="Deixe sua mensagem aqui..."></textarea>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Enviar <i class="mdi mdi-telegram ms-1"></i></button>
        </div>
    </div>
</form>

                    
                </div>
            </div>
        </div>
    </section>
    <!-- END CONTACT -->

    <!-- START FOOTER -->
    <footer class="bg-dark py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img src="assets/images/logo.png" alt="logo" class="logo-dark" height="22" />
                    <p class="text-light text-opacity-50 mt-4">Gestão Simplificada e Controle Total em um só lugar.
                    </p>

                    <ul class="social-list list-inline mt-3">
                        <li class="list-inline-item text-center">
                            <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                        </li>
                        <li class="list-inline-item text-center">
                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                        </li>
                        <li class="list-inline-item text-center">
                            <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                        </li>
                        <li class="list-inline-item text-center">
                            <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                        </li>
                    </ul>

                </div>

                {{-- <div class="col-lg-2 col-md-4 mt-3 mt-lg-0">
                    <h5 class="text-light">Company</h5>

                    <ul class="list-unstyled ps-0 mb-0 mt-3">
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">About Us</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Documentation</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Blog</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Affiliate Program</a></li>
                    </ul>

                </div>

                <div class="col-lg-2 col-md-4 mt-3 mt-lg-0">
                    <h5 class="text-light">Apps</h5>

                    <ul class="list-unstyled ps-0 mb-0 mt-3">
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Ecommerce Pages</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Email</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Social Feed</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Projects</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Tasks Management</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-4 mt-3 mt-lg-0">
                    <h5 class="text-light">Discover</h5>

                    <ul class="list-unstyled ps-0 mb-0 mt-3">
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Help Center</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Our Products</a></li>
                        <li class="mt-2"><a href="javascript: void(0);" class="text-light text-opacity-50">Privacy</a></li>
                    </ul>
                </div>
            </div> --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="mt-5">
                        <p class="text-light text-opacity-50 mt-4 text-center mb-0">©
                            <script>document.write(new Date().getFullYear())</script> ProcOnline - proconline.com.br
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>