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
    background-color: #fff;
    visibility: hidden;
    width: 0px;
    transition: all 0.3s ease-in-out 0s;
    
  }

  .navmenu ul li.dropdown ul a {
    text-align: left !important;
    justify-content: flex-start !important;
}


</style>


<header 
  id="header" 
  class="header d-flex align-items-center fixed-top 
  {{ request()->routeIs('loja.index') ? 'header-transparent' : 'header-solid' }}">

    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('loja.index') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ url('frontend/images/logo_texto.png') }}" alt="Alcecar">
      </a>
      @auth
      <nav id="navmenu" class="navmenu">
        <ul>
          <li>
              <a href="{{ url('/particulares/dashboard') }}" class="d-flex align-items-center">
                    Meu Painel
              </a>
          </li>
          <li>
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a href="#" class="d-flex align-items-center" onclick="event.preventDefault(); this.closest('form').submit();">
                        Sair
                  </a>
              </form>
          </li>
         
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      @endauth

      @guest
        <a class="cta-btn" href="{{ route('login') }}">ACESSAR</a>
      @endguest

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