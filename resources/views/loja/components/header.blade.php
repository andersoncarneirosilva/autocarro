<style>
/* --- ESTADO INICIAL (VERMELHO) --- */
#header {
    background-color: #5B0000;
    transition: all 0.4s ease;
    padding: 15px 0;
    display: flex;
    align-items: center;
    z-index: 997;
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

/* Links Desktop - Apenas para telas grandes */
@media (min-width: 1200px) {
    #header .navmenu ul li a {
        color: #ffffff !important;
    }
}

#header .mobile-nav-toggle {
    color: #ffffff !important;
}

#header .btn-getstarted {
    background: #ffffff;
    color: #5B0000;
    padding: 8px 25px;
    border-radius: 50px;
    transition: 0.3s;
    font-weight: 600;
    text-decoration: none;
}

/* --- ESTADO APÓS SCROLL (BRANCO) --- */
#header.header-scrolled {
    background-color: #ffffff;
    box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
    padding: 10px 0;
}

#header.header-scrolled .navmenu ul li a, 
#header.header-scrolled .mobile-nav-toggle {
    color: #333333 !important;
}

#header.header-scrolled .btn-getstarted {
    background: #5B0000;
    color: #ffffff;
}

/* --- DROPDOWN (SUBMENU DESKTOP) --- */
#header .navmenu .dropdown ul {
    background-color: #ffffff;
    box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
}

#header .navmenu .dropdown ul li a {
    color: #333333 !important;
}

/* --- AJUSTES ESPECÍFICOS PARA MOBILE --- */
@media (max-width: 1199px) {
    /* Força o ícone do menu a ser branco no topo vermelho */
    .mobile-nav-toggle {
        color: #ffffff !important;
    }

    /* Ajuste do Painel Lateral que abre */
    .navmenu ul {
        background-color: #ffffff !important;
    }

    /* Links do Menu Mobile (Força cor escura para ler no fundo branco) */
    .navmenu ul li a, 
    .navmenu .dropdown > a,
    .navmenu .dropdown > a span,
    .navmenu .dropdown > a i {
        color: #333333 !important;
    }

    /* Itens ativos ou hover no mobile */
    .navmenu ul li a:hover, 
    .navmenu ul li a.active,
    .navmenu .dropdown:hover > a {
        color: #5B0000 !important;
    }

    /* Botão e Hambúrguer lado a lado */
    #header .btn-getstarted {
        order: 2;
        margin-right: 15px;
        padding: 6px 15px;
        font-size: 13px;
    }
    #header .navmenu { order: 3; }
    #header .logo { order: 1; }
}

/* Estado Scrolled no Mobile */
#header.header-scrolled .mobile-nav-toggle {
    color: #333333 !important;
}
</style>
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
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