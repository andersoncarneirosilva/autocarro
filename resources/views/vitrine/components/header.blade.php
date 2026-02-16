<style>
/* Estado inicial na Home */
.header-transparent {
    background: transparent;
    box-shadow: none;
    transition: all 0.3s ease; /* Transição suave para a troca de cor */
}

/* Cor fixa nas outras páginas */
.header-solid {
    background: #b32d2d; 
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

/* Classe que o JS vai adicionar ao rolar */
.header-scrolled {
    background: #b32d2d !important; /* Cor que deseja ao rolar */
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
  {{ (request()->is('/') || (request()->is('loja/*') && !Str::contains(request()->url(), '/veiculo/'))) ? 'header-transparent' : 'header-solid' }}">

    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="#" class="logo d-flex align-items-center me-auto">
        <img src="{{ url('frontend/images/logo_texto.png') }}" alt="Alcecar">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#" class="#">Home</a></li>
          <li><a href="#" class="#">Revendas</a></li>
          <li><a href="#" class="#">Novos</a></li>
          <li><a href="#" class="#">Semi-novos</a></li>
          <li><a href="#" class="#">Usados</a></li>
          {{-- <li class="dropdown">
            <a href="#"><span>Especiais</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Clássicos</a></li>
              <li><a href="#">Esportivos</a></li>
              <li><a href="#">Modificados</a></li>
            </ul>
          </li> --}}

          {{-- Dropdown de Usuário para Mobile --}}
          @auth
          <li class="dropdown d-xl-none">
            <a href="#"><span>Minha Conta</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              {{-- Lógica de Redirecionamento Mobile --}}
              <li>
                <a href="{{ auth()->user()->nivel_acesso === 'Particular' ? route('particulares.index') : url('/dashboard') }}">
                    Meu Painel
                </a>
              </li>
              @if(auth()->user()->nivel_acesso === 'Revenda' && auth()->user()->revenda)
                <li><a href="{{ url('/loja/' . auth()->user()->revenda->slug) }}">Minha Loja</a></li>
              @endif
              <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
                </form>
              </li>
            </ul>
          </li>
          @endauth
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      @auth
        <div class="d-flex align-items-center">
          
            <nav class="navmenu">
                <ul>
                    <li class="dropdown">
                        <a href="#" class="p-0 border-0">
                            @if(auth()->user()->image)
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="user-image" width="40" height="40" class="rounded-circle border border-white shadow-sm">
                            @else
                                <div class="avatar-text" style="width: 40px; height: 40px; background-color: #730000; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <i class="bi bi-chevron-down toggle-dropdown ms-1" style="font-size: 0.7rem;"></i>
                        </a>
                        <ul style="right: 0; left: auto; min-width: 200px;">
                            <li class="px-3 py-2 border-bottom mb-1" style="font-size: 0.85rem; color: #666;">
                                <span>Olá, <strong>{{ explode(' ', auth()->user()->name)[0] }}</strong></span>
                                
                            </li>

                            <li>
                                <a href="{{ auth()->user()->nivel_acesso === 'Particular' ? route('particulares.index') : url('/dashboard') }}" class="d-flex align-items-center">
                                    <i class="bi bi-speedometer2 me-2"></i> Meu Painel
                                </a>
                            </li>

                            @if(auth()->user()->nivel_acesso === 'Revenda' && auth()->user()->revenda)
                                <li>
                                    <a href="{{ url('/loja/' . auth()->user()->revenda->slug) }}" class="d-flex align-items-center">
                                        <i class="bi bi-shop me-2"></i> Minha loja
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider mx-2"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#" class="text-danger d-flex align-items-center" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
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