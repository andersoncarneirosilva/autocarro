<style>
/* Estado inicial na Home */
.header-transparent {
    background: transparent;
    box-shadow: none;
    transition: all 0.3s ease; /* Transição suave para a troca de cor */
}

/* Cor fixa nas outras páginas */
.header-solid {
    background: #ff4a17; 
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

/* Classe que o JS vai adicionar ao rolar */
.header-scrolled {
    background: #ff4a17 !important; /* Cor que deseja ao rolar */
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
    padding: 10px 0; /* Opcional: diminui um pouco a altura ao rolar */
}
.navmenu>ul>li>a:before {
    content: "";
    position: absolute;
    height: 2px;
    bottom: -6px;
    left: 0;
    background-color: var(--nav-hover-color);
    visibility: hidden;
    width: 0px;
    transition: all 0.3s ease-in-out 0s;
    
  }
</style>
<header 
  id="header" 
  class="header d-flex align-items-center fixed-top 
  {{ request()->routeIs('loja.index') ? 'header-transparent' : 'header-solid' }}">

    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('loja.index') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ url('carbook/img/logo_texto.png') }}" alt="Alcecar">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const header = document.querySelector('#header');
  
  // Função que verifica o scroll
  function handleScroll() {
    if (window.scrollY > 50) {
      header.classList.add('header-scrolled');
    } else {
      header.classList.remove('header-scrolled');
    }
  }

  // Executa ao carregar a página (caso já comece no meio)
  handleScroll();

  // Executa toda vez que rolar
  window.addEventListener('scroll', handleScroll);
});
</script>