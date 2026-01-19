<style>
    /* Apenas na home */
.header-transparent {
    background: transparent;
    box-shadow: none;
}

/* Demais páginas */
.header-solid {
    background: #ff4a17; /* ou a cor do seu tema */
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

</style>
<header 
  id="header" 
  class="header d-flex align-items-center fixed-top 
  {{ request()->routeIs('loja.index') ? 'header-transparent' : 'header-solid' }}">

    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('loja.index') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ url('layout/images/logo_carro.png') }}" alt="Logo">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li>
            <a href="{{ route('loja.index') }}" class="{{ request()->routeIs('loja.index') ? 'active' : '' }}">
              Home
            </a>
          </li>
          
          <li>
            <a href="{{ route('veiculos.novos') }}" class="{{ request()->routeIs('veiculos.novos') ? 'active' : '' }}">
              Novos
            </a>
          </li>

          <li>
            <a href="{{ route('veiculos.semi-novos') }}" class="{{ request()->routeIs('veiculos.semi-novos') ? 'active' : '' }}">
              Semi-novos
            </a>
          </li>

          <li>
            <a href="{{ route('veiculos.usados') }}" class="{{ request()->routeIs('veiculos.usados') ? 'active' : '' }}">
              Usados
            </a>
          </li>

          <li class="dropdown">
            <a href="#"><span>Especiais</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Clássicos</a></li>
              <li><a href="#">Esportivos</a></li>
              <li><a href="#">Modificados</a></li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="cta-btn" href="{{ route('login') }}">ACESSAR</a>

    </div>
</header>

