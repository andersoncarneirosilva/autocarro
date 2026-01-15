<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ route('site.index') }}" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Autocar</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li>
                    <a href="{{ route('site.index') }}"
                       class="{{ request()->routeIs('site.index') ? 'active' : '' }}">
                        Home
                    </a>
                </li>
          {{-- <li><a href="about.html">Ofertas</a></li> --}}
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
              {{-- <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li> --}}
              
            </ul>
          </li>
          <li><a href="contact.html">Contato</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route('login') }}">ACESSAR</a>

    </div>
  </header>