<footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Alcecar</span>
          </a>
          
          <p>Na Alcecar, você não procura sozinho. Conectamos você ao veículo certo com uma curadoria inteligente e acompanhamento especializado do início ao fim, garantindo uma escolha segura e sem complicações.</p>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
    <h4>Links Úteis</h4>
    <ul>
        <li><a href="{{ route('veiculos.novos')}}">Veículos Novos</a></li>
        <li><a href="{{ route('veiculos.semi-novos')}}">Veículos Semi-novos</a></li>
        <li><a href="{{ route('veiculos.usados')}}">Veículos Usados</a></li>
    </ul>
</div>

<div class="col-lg-2 col-md-3 footer-links">
    <h4>Lojista</h4>
    <ul>
        <li><a href="{{ route('login')}}">Área do lojista</a></li>
        <li><a href="{{ route('anuncios.index') }}">Gerenciar anúncios</a></li>
    </ul>
</div>

<div class="col-lg-4 col-md-12 footer-newsletter">
    <h4>Nossa Newsletter</h4>
    <p>Assine nossa newsletter e receba as últimas ofertas e novidades do nosso estoque!</p>
    <form action="forms/newsletter.php" method="post" class="php-email-form">
        <div class="newsletter-form">
            <input type="email" name="email" placeholder="Seu e-mail">
            <input type="submit" value="Inscrever">
        </div>
        <div class="loading">Carregando</div>
        <div class="error-message"></div>
        <div class="sent-message">Sua solicitação de inscrição foi enviada. Obrigado!</div>
    </form>
</div>

      </div>
    </div>

    <div class="container copyright text-center">
      {{-- <p>© <strong class="px-1 sitename">alcecar</strong> <span>Todos os direitos reservados</span></p> --}}
      <div class="credits">
        Desenvolvido por <a href="https://pixdesign.com.br/">PixDesign</a>
      </div>
    </div>

  </footer>