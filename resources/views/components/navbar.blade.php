<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="index.html" class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ url('assets/images/logo.png') }}" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ url('assets/images/logo-sm.png') }}" alt="small logo">
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="index.html" class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ url('assets/images/logo-dark.png') }}" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ url('assets/images/logo-dark-sm.png') }}" alt="small logo">
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="mdi mdi-menu"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            
            <!-- Verifica se estamos na página de usuários antes de mostrar o formulário -->
            @if(request()->routeIs('procuracoes.index'))
                <div class="app-search dropdown d-none d-lg-block">
                    <form action="{{ route('procuracoes.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="Pesquisar procuração" class="form-control">
                            <button type="submit" class="btn btn-primary">Pesquisar</button>
                        </div>
                    </form>
                </div>
            @elseif(request()->routeIs('veiculos.index'))
                <div class="app-search dropdown d-none d-lg-block">
                    <form action="{{ route('veiculos.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="Informe a placa" class="form-control">
                            <span class="mdi mdi-magnify search-icon"></span>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                </div>
            @elseif(request()->routeIs('users.index'))
                <div class="app-search dropdown d-none d-lg-block">
                    <form action="{{ route('users.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="Pesquisar" class="form-control">
                            <button type="submit" class="btn btn-primary">Pesquisar</button>
                        </div>
                    </form>
                </div>
            @elseif(request()->routeIs('clientes.index'))
            <div class="app-search dropdown d-none d-lg-block">
                <form action="{{ route('clientes.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Buscar clientes" class="form-control">
                        <span class="mdi mdi-magnify search-icon"></span>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>
            @elseif(request()->routeIs('documentos.index'))
            <div class="app-search dropdown d-none d-lg-block">
                <form action="{{ route('documentos.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="Pesquisar veículos..." class="form-control">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                </form>
            </div>
            @endif

        </div>

        {{-- Notificações --- HABILITAR notificaçoes.js --}}
        {{-- <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Seleciona o elemento de dropdown
                const dropdownToggle = document.querySelector('.notification-list .dropdown-toggle');
                const notiBadge = document.querySelector('.noti-icon-badge');
        
                if (dropdownToggle && notiBadge) {
                    dropdownToggle.addEventListener('click', function () {
                        // Remove a classe quando o dropdown é clicado
                        notiBadge.classList.remove('noti-icon-badge');
                    });
                }
            });

            const observer = new MutationObserver(() => {
    const navbarBadge = document.querySelector('.noti-icon-badge');
    if (navbarBadge) {
        navbarBadge.classList.add('noti-icon-badge');
        observer.disconnect(); // Parar de observar após encontrar o elemento
    }
});

// Observar mudanças no body
observer.observe(document.body, { childList: true, subtree: true });

        </script> --}}
        
        <ul class="topbar-menu d-flex align-items-center gap-3">
            @if(request()->routeIs('veiculos.index'))
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line font-22"></i>
                </a>
                
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0" style="">
                    <form action="{{ route('veiculos.index') }}" method="GET" class="p-3">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="Informe a placa" class="form-control" required>
                            <button type="submit" class="btn btn-primary"><i class="ri-search-line font-22"></i></button>
                        </div>
                    </form>
                </div>
            </li>
            @elseif(request()->routeIs('clientes.index'))
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line font-22"></i>
                </a>
                
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0" style="">
                    <form action="{{ route('clientes.index') }}" method="GET" class="p-3">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="Informe o cliente" class="form-control" required>
                            <button type="submit" class="btn btn-primary"><i class="ri-search-line font-22"></i></button>
                        </div>
                    </form>
                </div>
            </li>
            @endif

            {{-- Notificações --- HABILITAR notificaçoes.js --}}
            {{-- Notificações --- HABILITAR script logo acima nessa pagina --}}
            {{-- <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-notification-3-line font-22"></i>
                    <span class="noti-icon-badge"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-16 fw-semibold"> Notificações</h6>
                            </div>
                            <div class="col-auto">
                                <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                                    <small>Limpar</small>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="px-2" style="max-height: 300px;" data-simplebar>
                        <a href="javascript:void(0);" class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-2">
                            <div id="notifications-list"></div>
                        </a>
                    </div>
                </div>
            </li> --}}
            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="Tema escuro">
                    <i class="ri-moon-line font-22"></i>
                </div>
            </li>


            <li class="d-none d-md-inline-block">
                <a class="nav-link" href="" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line font-22"></i>
                </a>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        @if(auth()->user()->image)
                        <img src="../../storage/{{ auth()->user()->image }}" alt="user-image" width="32"
                            class="rounded-circle">
                        @else
                        <img src="{{ url('assets/img/icon_user.png') }}" alt="user-image" width="32"
                            class="rounded-circle">
                        @endif
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">{{ auth()->user()->name }}</h5>
                        <h6 class="my-0 fw-normal">{{ auth()->user()->perfil }}</h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Menu</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('perfil.index') }}" class="dropdown-item">
                        <i class="mdi mdi-account-circle me-1"></i>
                        <span>Perfil</span>
                    </a>

                    <!-- item-->
                    {{-- <a href="javascript:void(0);" class="dropdown-item">
                        <i class="mdi mdi-account-edit me-1"></i>
                        <span>Configurações</span>
                    </a> --}}

                    <!-- item-->

                    <form action="{{ route('logout') }}" method="POST" id="exit">
                        @csrf
                        <button class="dropdown-item confirmBtn"><i class="mdi mdi-logout me-1"></i>
                            <span>Sair</span></button>
                    </form>
                    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        // Captura o evento de clique nos botões de confirmação de pagamento
                        const confirmButtons = document.querySelectorAll('.confirmBtn');
                        confirmButtons.forEach(function(button) {
                            button.addEventListener('click', function(e) {
                                e.preventDefault(); // Impede o envio do formulário

                                const parcela = button.getAttribute('data-parcela');

                                // Exibe o Sweet Alert para confirmar o pagamento
                                Swal.fire({
                                    title: 'Deseja sair do sistema?',
                                    text: `Você será redirecionado para a tela de login!`,
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sim',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Se o usuário confirmar, envia o formulário
                                        //const formId = button.parentNode.getAttribute('id');
                                        document.getElementById('exit').submit();
                                    }
                                });
                            });
                        });
                    </script>

                </div>
            </li>
        </ul>
    </div>
</div>
