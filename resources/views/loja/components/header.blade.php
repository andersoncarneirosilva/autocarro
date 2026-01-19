<style>
/* --- 1. CONFIGURAÇÕES BASE --- */
#header {
    background-color: transparent;
    transition: all 0.4s ease;
    padding: 15px 0;
    display: flex;
    align-items: center;
    z-index: 997;
    height: 80px;
}

#header .container-fluid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}

#header .logo img {
    max-height: 40px;
    transition: all 0.4s ease;
}

/* --- 2. ESTADO TRANSPARENTE (Home e Detalhes) --- */
/* Links brancos para fundo transparente com imagem atrás */
#header .navmenu ul li a {
    color: #ffffff !important;
    font-weight: 500;
    transition: 0.3s;
}

#header .mobile-nav-toggle {
    color: #ffffff !important;
}

#header .btn-getstarted {
    background: #ffffff;
    color: #ff4a17;
    padding: 8px 25px;
    border-radius: 50px;
    transition: 0.3s;
    font-weight: 600;
    text-decoration: none;
    border: 2px solid transparent;
}

/* --- 3. ESTADO FIXO COLORIDO (Páginas como /veiculos-novos) --- */
/* Aplicado via Blade quando não é index ou show */
#header.header-dark-text {
    background-color: #ff4a17 !important;
    box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
}

#header.header-dark-text .navmenu ul li a,
#header.header-dark-text .mobile-nav-toggle {
    color: #ffffff !important;
}

#header.header-dark-text .btn-getstarted {
    background: #ffffff !important;
    color: #ff4a17 !important;
}

/* --- 4. ESTADO APÓS SCROLL (Sempre Branco) --- */
#header.header-scrolled {
    background-color: #ffffff !important;
    box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
    padding: 10px 0;
    height: 70px;
}

#header.header-scrolled .navmenu ul li a, 
#header.header-scrolled .mobile-nav-toggle {
    color: #333333 !important;
}

#header.header-scrolled .btn-getstarted {
    background: #ff4a17 !important;
    color: #ffffff !important;
}

/* --- 5. DROPDOWN (SUBMENU DESKTOP) - CORREÇÃO --- */
/* Garante fundo branco e texto escuro INDEPENDENTE da página */
#header .navmenu .dropdown ul {
    background-color: #ffffff !important;
    box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.15);
    border-radius: 4px;
}

#header .navmenu .dropdown ul li a {
    color: #333333 !important; /* Texto sempre escuro no dropdown */
    padding: 10px 20px;
    font-size: 14px;
}

#header .navmenu .dropdown ul li a:hover {
    color: #ff4a17 !important;
    background-color: #f8f9fa;
}

/* --- 6. MOBILE NAV --- */
@media (max-width: 1199px) {
    #header .navmenu ul {
        background-color: #ffffff !important; /* Fundo do menu lateral */
    }

    #header .navmenu ul li a {
        color: #333333 !important; /* Texto sempre escuro no mobile aberto */
    }

    #header .btn-getstarted {
        order: 2;
        margin-right: 15px;
        padding: 6px 15px;
        font-size: 13px;
    }
}
</style><header id="header" class="header d-flex align-items-center fixed-top {{ !in_array(Route::currentRouteName(), ['loja.index']) ? 'header-dark-text' : '' }}">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('loja.index') }}" class="logo d-flex align-items-center me-auto">
        {{-- Usando a sua logo do antigo menu --}}
        <img src="{{ url('layout/images/logo_carro.png') }}" alt="Logo">
        {{-- Caso queira exibir o nome ao lado da logo, use a sitename abaixo --}}
        {{-- <h1 class="sitename">Carbook</h1> --}}
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

      {{-- Ajustado para o estilo cta-btn do novo template mas com sua rota de login --}}
      <a class="cta-btn" href="{{ route('login') }}">ACESSAR</a>

    </div>
</header>

  <script>
document.addEventListener('scroll', () => {
    const header = document.querySelector('#header');
    if (window.scrollY > 50) {
        header.classList.add('header-scrolled');
    } else {
        header.classList.remove('header-scrolled');
    }
});
</script>