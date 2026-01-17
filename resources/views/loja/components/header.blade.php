<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ route('loja.index') }}" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename"><img src="{{ url('layout/images/logo_carro.png') }}" alt=""></h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li>
                    <a href="{{ route('loja.index') }}"
                       class="{{ request()->routeIs('site.index') ? 'active' : '' }}">
                        Home
                    </a>
                </li>
          <li>
                    <a href="{{ route('veiculos.novos') }}"
                       class="{{ request()->routeIs('veiculos.novos') ? 'active' : '' }}">
                        Novos
                    </a>
                </li>
          <li>
                    <a href="{{ route('veiculos.semi-novos') }}"
                       class="{{ request()->routeIs('veiculos.semi-novos') ? 'active' : '' }}">
                        Semi-novos
                    </a>
                </li>
          <li>
            <a href="{{ route('veiculos.usados') }}"
               class="{{ request()->routeIs('veiculos.usados') ? 'active' : '' }}">
                Usados
            </a>
        </li>
          <li class="dropdown"><a href="#"><span>Especiais</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Clássicos</a></li>
              <li><a href="#">Esportivos</a></li>
              <li><a href="#">Modificados</a></li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route('login') }}">ACESSAR</a>

    </div>
  </header>