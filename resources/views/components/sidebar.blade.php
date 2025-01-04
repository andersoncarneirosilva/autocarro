<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="/" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ url('assets/images/logo.png') }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ url('assets/images/logo-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="/" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ url('assets/images/logo-dark.png') }}" alt="dark logo">
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
                <a href="{{ route('procuracoes.index') }}" class="side-nav-link">
                    <i class="uil-file"></i>
                    <span> Procurações </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('documentos.index') }}" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> Veículos </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('ordensdeservicos.index') }}" class="side-nav-link">
                    <i class="uil-clipboard-notes"></i>
                    <span> Ordens de Serviços </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('clientes.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Clientes </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('calendar.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Calendário </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('relatorios.index') }}" class="side-nav-link">
                    <i class="uil-file-info-alt"></i>
                    <span> Relatórios </span>
                </a>
            </li>

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

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayoutss" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span> Configurações </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLayoutss">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('configuracoes.index') }}">Procuração</a>
                        </li>
                        {{-- @can('access') 
                        <li>
                            <a href="{{ route('users.index') }}">Usuários</a>
                        </li>
                        @endcan --}}
                        <li>
                            <a href="{{ route('users.index') }}">Usuários</a>
                        </li>
                    </ul>
                </div>
            </li>


        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>