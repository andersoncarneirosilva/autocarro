<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="#" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo.png') }}?v={{ time() }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ url('assets/images/logo-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="#" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-dark.png') }}?v={{ time() }}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ url('assets/images/logo-dark-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Menu</li>

            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            
            <li class="side-nav-item">
                <a href="{{ route('veiculos.index') }}/" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> Veículos </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('veiculos.arquivados') }}/" class="side-nav-link">
                    <i class="uil-car-slash"></i>
                    <span class="badge bg-danger text-white float-end">Novo</span>
                    <span> Arquivados </span>
                </a>
            </li>

            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCar" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span> Veículos </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCar">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('veiculos.index') }}">Listagem</a>
                        </li>
                        <li>
                            <a href="{{ route('veiculos.arquivados') }}">Arquivados</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            {{-- @can('access-admin')
            <li class="side-nav-item">
                <a href="{{ route('documentos.index') }}" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> Veículos </span>
                </a>
            </li>
            
            <li class="side-nav-item">
                <a href="{{ route('estoque.index') }}" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> Estoque </span>
                </a>
            </li>
            
            <li class="side-nav-item">
                <a href="{{ route('ordensdeservicos.index') }}" class="side-nav-link">
                    <i class="uil-clipboard-notes"></i>
                    <span> Ordens de Serviços </span>
                </a>
            </li> --}}

            <li class="side-nav-item">
                <a href="{{ route('clientes.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Clientes </span>
                </a>
            </li>
            
            {{-- <li class="side-nav-item">
                <a href="{{ route('calendar.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Calendário </span>
                </a>
            </li> --}}

            {{-- @endcan --}}
            <li class="side-nav-item">
                <a href="{{ route('relatorios.index') }}" class="side-nav-link">
                    <i class="uil-file-info-alt"></i>
                    <span> Relatórios </span>
                </a>
            </li>
            {{-- @can('access-admin')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideCad" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-folder-medical"></i>
                    <span> Cadastros </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideCad">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('servicos.index') }}">Serviços</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan --}}
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayoutss" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span> Configurações </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLayoutss">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('outorgados.index') }}">Outorgados</a>
                        </li>
                        <li>
                            <a href="{{ route('configuracoes.index') }}">Procuração</a>
                        </li>
                        @can('access-admin') 
                        <li>
                            <a href="{{ route('users.index') }}">Usuários</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>

            {{-- <div class="help-box text-white text-center">
                <a href="javascript: void(0);" class="float-end close-btn text-white">
                    <i class="mdi mdi-close"></i>
                </a>
                <img src="assets/images/svg/help-icon.svg" height="90" alt="Helper Icon Image">
                <h5 class="mt-3">Unlimited Access</h5>
                <p class="mb-3">Upgrade to plan to get access to unlimited reports</p>
                <a href="javascript: void(0);" class="btn btn-secondary btn-sm">Upgrade</a>
            </div> --}}


        </ul>
        <!--- End Sidemenu -->

        {{-- <div class="clearfix"></div> --}}
    </div>
</div>