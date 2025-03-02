
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>ProcOnline create</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="{{ url('assets/js/hyper-config.js') }}"></script>

    <!-- App css -->
    <link href="{{ url('assets/css/app-saas.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
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
                            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" id="idFormUser" class="form-horizontal">
                                @csrf
                                
                                <div class="row g-5">
                                    <div class="col-lg-12">
                                      <h4 class="mb-3">Informações pessoais</h4>
                                        <div class="row g-3">
                                          <div class="col-sm-6">
                                            <label for="firstName" class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="name">
                                          </div>
                                
                                          <div class="col-sm-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email">
                                          </div>
                                
                                          <div class="col-sm-6">
                                            <label for="email" class="form-label">Senha</label>
                                            <input type="password" class="form-control" name="password">
                                          </div>
                                
                                          <div class="col-sm-6">
                                            <label for="email" class="form-label">Confirmar senha</label>
                                            <input type="password" class="form-control" name="password_confirmation">
                                          </div>
                                          <br>
                                          <hr class="my-4">
                                          <h5 class="mb-3">Informações da empresa</h5>
                                          <div class="col-lg-12">
                                            <label for="zip" class="form-label">Nome da empresa</label>
                                            <input type="text" class="form-control" name="database">
                                          </div>
                                          <div class="col-md-2">
                                            <label for="zip" class="form-label">CEP</label>
                                            <input type="text" class="form-control" name="cep">
                                          </div>
                                
                                          <div class="col-md-6">
                                            <label for="zip" class="form-label">Endereço</label>
                                            <input type="text" class="form-control" name="endereco">
                                          </div>
                                
                                          <div class="col-md-4">
                                            <label for="zip" class="form-label">Bairo</label>
                                            <input type="text" class="form-control" name="bairro">
                                          </div>
                                
                                          <div class="col-md-4">
                                            <label for="zip" class="form-label">Cidade</label>
                                            <input type="text" class="form-control" name="cidade">
                                          </div>
                                
                                          <div class="col-md-4">
                                            <label for="zip" class="form-label">Estado</label>
                                            <input type="text" class="form-control" name="estado">
                                          </div>
                                
                                          <div class="col-md-4">
                                            <label for="zip" class="form-label">Complemento</label>
                                            <input type="text" class="form-control" name="complemento">
                                          </div>
                                
                                          <div class="col-md-4">
                                            <label for="zip" class="form-label">Telefone</label>
                                            <input type="text" class="form-control" name="telefone">
                                          </div>
                                
                                          <div class="col-md-4">
                                            <label for="zip" class="form-label">Celular</label>
                                            <input type="text" class="form-control" name="celular">
                                          </div>
                                
                                          <div class="col-md-4">
                                                <label for="zip" class="form-label">Logo</label>
                                                <input class="form-control" type="file" name="image">
                                                      
                                          </div>
                                
                                
                                
                                        </div>
                                
                                
                                        
                                
                                        <hr class="my-4">
                                
                                        <button class="w-100 btn btn-primary btn-lg" type="submit">Cadastrar</button>
                                    </div>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <!-- END PRICING -->

    

    

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
    <script src="{{ url('assets/js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ url('assets/js/app.min.js') }}"></script>

</body>

</html>