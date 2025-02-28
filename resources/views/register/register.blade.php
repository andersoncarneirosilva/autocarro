
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ProcOnline registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

   
    <!-- NAVBAR END -->

    <!-- START SERVICES -->
    
    <!-- END FEATURES 1 -->

    

    <!-- START PRICING -->
    <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <section class="py-5">
            <div class="container px-5">
                <!-- Contact form-->
                <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="fa-solid fa-shop"></i></div>
                        <p class="lead fw-normal text-muted mb-0">Cadastre o seu negócio!</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-12 col-xl-12">
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                            <form action="{{ route('site.store') }}" method="POST" enctype="multipart/form-data" id="idFormUser" class="form-horizontal">
                                @csrf
                                @include('site._partials.form-cad')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

                        <button type="button" class="btn btn-success btn-sm mt-2"><i class="mdi mdi-whatsapp me-1"></i> (51)99486.7806</button>
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
                        <p class="faq-answer mb-4 pb-1 text-muted">Nosso suporte funciona 24/7 por email ou whatsapp. 
                            <br>Não deixe de entrar em contato.</p>
                    </div>

                </div>
                <!--/col-lg-5 -->

                <div class="col-lg-5">
                    <!-- Question/Answer -->
                    <div>
                        <div class="faq-question-q-box">Q.</div>
                        <h4 class="faq-question text-body">Como faço para testar o ProcOnline?</h4>
                        <p class="faq-answer mb-4 pb-1 text-muted"><a href="">Clique aqui</a> e faça um simples cadastro para acessar o sistema.</p>
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
                    <p class="text-muted"><span class="fw-bold">Suporte 24/7:</span><br> <span class="d-block mt-1">51 994867806</span></p>
                    <p class="text-muted mt-4"><span class="fw-bold">Email:</span><br> <span class="d-block mt-1">suporte@proconline.com.br</span></p>
                    <p class="text-muted mt-4"><span class="fw-bold">Atendimento:</span><br> <span class="d-block mt-1">Seg. a Sex. - 9:00AM as 6:00PM</span></p>
                </div>

                <div class="col-md-7">
                    <form>
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="fullname" class="form-label">Nome</label>
                                    <input class="form-control form-control-light py-2" type="text" id="fullname" placeholder="Seu nome...">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="emailaddress" class="form-label">Email</label>
                                    <input class="form-control form-control-light py-2" type="email" required="" id="emailaddress" placeholder="Seu melhor email...">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <label for="comments" class="form-label">Mensagem</label>
                                    <textarea id="comments" rows="4" class="form-control form-control-light" placeholder="Deixe sua mensagem aqui..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 text-end">
                                <button class="btn btn-primary">Enviar <i class="mdi mdi-telegram ms-1"></i> </button>
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
                            <script>document.write(new Date().getFullYear())</script> ProcOnline. www.proconline.com.br
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>