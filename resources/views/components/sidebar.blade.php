
<div class="leftside-menu">

    <a href="{{ route('dashboard.index') }}" class="logo logo-light">
        <span class="logo-lg">
             <img src="{{ asset('frontend/images/logo_texto.png') }}?v={{ time() }}" alt="logo" height="22">
        </span>
        <span class="logo-sm">
            <img src="{{ url('frontend/images/logo_alcecar.png') }}" alt="small logo" height="22">
        </span>
    </a>

    <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('frontend/images/logo_texto.png') }}?v={{ time() }}" alt="dark logo" height="22">
        </span>
        <span class="logo-sm">
            <img src="{{ url('frontend/images/logo_alcecar.png') }}" alt="small logo" height="22">
        </span>
    </a>

    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <ul class="side-nav">

            <li class="side-nav-title">Principal</li>
            
            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            {{-- <li class="side-nav-title">Gestão de Veículos</li> --}}
            
            <li class="side-nav-item">
                <a href="{{ route('agenda.index') }}" class="side-nav-link">
                    <i class="uil-calendar-alt"></i>
                    <span> Agenda </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('estoque.index') }}" class="side-nav-link">
                    <i class="uil-image"></i>
                    <span> Estoque </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarFinanceiro" aria-expanded="false" aria-controls="sidebarFinanceiro" class="side-nav-link">
                    <i class="uil-usd-circle"></i>
                    <span> Financeiro </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarFinanceiro">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('financeiro.index') }}">Resumo Geral</a>
                        </li>
                        <li>
                            <a href="{{ route('financeiro.receber') }}">Contas a Receber</a>
                        </li>
                        <li>
                            <a href="{{ route('financeiro.pagar') }}">Contas a Pagar</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('empresa.index') }}" class="side-nav-link">
                    <i class="uil-image"></i>
                    <span> Perfil da Empresa </span>
                </a>
            </li>



            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#cadastros" aria-expanded="false" aria-controls="cadastros" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Cadastros </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="cadastros">
                    <ul class="side-nav-second-level">
                        <li><a href="{{ route('clientes.index') }}">Clientes</a></li>
                        <li><a href="{{ route('profissionais.index') }}">Profissionais</a></li>
                        <li><a href="{{ route('servicos.index') }}">Serviços</a></li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Sistema</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#configuracao" aria-expanded="false" aria-controls="configuracao" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span> Configurações </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="configuracao">
                    <ul class="side-nav-second-level">
                        <li><a href="{{ route('whatsapp.index') }}">Whatsapp</a></li>
                        <li><a href="{{ route('galeria.index') }}">Galeria de Fotos</a></li>
                        @can('access-admin') 
                        <li><a href="{{ route('users.index') }}">Usuários</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        </ul>

        <div class="help-box text-white text-center">
            <h5 class="mt-3">Suporte</h5>
            <p class="mb-3">Dúvidas ou problemas?</p>
            <a href="https://wa.me/5551999047299" target="_blank" class="btn btn-outline-light btn-sm text-white">Chamar no Whats</a>
        </div>

    </div>
</div>