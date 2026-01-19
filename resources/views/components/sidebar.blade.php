<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="#" class="logo logo-light">
        <span class="logo-lg">
             <img src="{{ asset('layout/images/logo_texto.png') }}?v={{ time() }}" alt="logo"> {{-- MENU LATERAL --}}
        </span>
        <span class="logo-sm">
            <img src="{{ url('layout/images/logo_alcecar.png') }}" alt="small logo"> {{-- MENU RECOLHIDO --}}
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="#" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('layout/images/logo_texto.png') }}?v={{ time() }}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ url('layout/images/logo_texto.png') }}?v={{ time() }}" alt="small logo">
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

        <ul class="side-nav">

            <li class="side-nav-title">Menu</li>
            @can('access-admin')
            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="uil-apps"></i>
                    <span> Dashboard </span>
                </a>
            </li>
@endcan
            {{-- <li class="side-nav-item">
                <a href="{{ route('anuncios.index') }}" class="side-nav-link">
                    <i class="mdi mdi-help-circle-outline"></i>
                    <span> Anuncios </span>
                </a>
            </li> --}}

            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#configuracao" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> Anuncios </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="configuracao">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('anuncios.index') }}">Ativos</a>
                        </li>
                        <li>
                            <a href="{{ route('anuncios.arquivados') }}">Arquivados</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            
            <li class="side-nav-item">
                <a href="{{ route('anuncios.index') }}" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> Anúncios ativos </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('anuncios.arquivados') }}/" class="side-nav-link">
                    <i class="uil-car-slash"></i>
                    
                    <span> Anúncios Arquivados </span>
                </a>
            </li>


            <li class="side-nav-item">
                <a href="{{ route('clientes.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Clientes </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#configuracao" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span> Configurações </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="configuracao">
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
            
            
        </ul>
    </div>
</div>