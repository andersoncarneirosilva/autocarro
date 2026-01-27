<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="#" class="logo logo-light">
        <span class="logo-lg">
             <img src="{{ asset('frontend/images/logo_texto.png') }}?v={{ time() }}" alt="logo"> {{-- MENU LATERAL --}}
        </span>
        <span class="logo-sm">
            <img src="{{ url('frontend/images/logo_alcecar.png') }}" alt="small logo"> {{-- MENU RECOLHIDO --}}
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="#" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('frontend/images/logo_texto.png') }}?v={{ time() }}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ url('frontend/images/logo_texto.png') }}?v={{ time() }}" alt="small logo">
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
            
            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="uil-apps"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            {{-- <li class="side-nav-item">
                <a href="{{ route('veiculos.index') }}" class="side-nav-link">
                    <i class="mdi mdi-help-circle-outline"></i>
                    <span> veiculos </span>
                </a>
            </li> --}}

            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#configuracao" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> veiculos </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="configuracao">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('veiculos.index') }}">Ativos</a>
                        </li>
                        <li>
                            <a href="{{ route('veiculos.arquivados') }}">Arquivados</a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            
            <li class="side-nav-item">
                <a href="{{ route('veiculos.index') }}" class="side-nav-link">
                    <i class="uil-car"></i>
                    <span> Veículos ativos </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('veiculos.arquivados') }}/" class="side-nav-link">
                    <i class="uil-car-slash"></i>
                    
                    <span> Veículos Arquivados </span>
                </a>
            </li>


            <li class="side-nav-item">
                <a href="{{ route('clientes.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Clientes </span>
                </a>
            </li>   
            
            <li class="side-nav-item">
                <a href="{{ route('multas.index') }}" class="side-nav-link">
                    <i class="uil-file-alt"></i>
                    <span> Multas </span>
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
                        <li>
                            <a href="{{ route('configuracoes.solicitacao.indexAtpve') }}">Solicitação ATPVe</a>
                        </li>
                        @can('access-admin') 
                        <li>
                            <a href="{{ route('users.index') }}">Usuários</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            {{-- @if(auth()->user()->nivel_acesso === 'Revenda' && auth()->user()->revenda)
            <div class="help-box text-white text-center">
                        <img src="assets/images/svg/help-icon.svg" height="90" alt="Helper Icon Image">
                        <h5 class="mt-3">Minha loja</h5>
                        <p class="mb-3">Ver loja</p>
                        <a href="{{ url('/loja/' . auth()->user()->revenda->slug) }}" class="btn btn-secondary btn-sm">Ver loja</a>
                    </div>
            @endif --}}
            {{-- <div class="mt-auto"></div>
            @if(auth()->user()->nivel_acesso === 'Revenda' && auth()->user()->revenda)
    <div class="help-box text-white text-center">
        <div class="mb-2">
            <i class="mdi mdi-storefront-outline" style="font-size: 2.5rem; opacity: 0.8;"></i>
        </div>
        
        <h5 class="mt-0 small fw-bold text-uppercase" style="letter-spacing: 1px;">Minha Loja</h5>
        <p class="mb-2 small opacity-75">Confira como os clientes veem sua loja</p>
        
        <a href="{{ url('/loja/' . auth()->user()->revenda->slug) }}" 
           target="_blank" 
           class="btn btn-sm btn-light fw-bold shadow-sm px-3">
            <i class="mdi mdi-open-in-new me-1"></i> Acessar Loja
        </a>
    </div>
@endif

<style>
    /* Ajuste para o Sidebar do Alcecar */
    .help-box {
        background: rgba(255, 255, 255, 0.07); /* Fundo sutil para o sidebar dark */
        margin: 15px;
        padding: 20px 10px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    /* Se o sidebar for Laranja Alcecar */
    .leftside-menu-dark .help-box {
        background: #ff4a17; /* Cor sólida caso queira destaque total */
    }
</style> --}}
            
        </ul>
    </div>
</div>