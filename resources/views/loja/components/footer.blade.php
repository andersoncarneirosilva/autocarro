<footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('loja.index') }}" class="logo d-flex align-items-center">
            <span class="sitename">Alcecar</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Na Alcecar, você não procura sozinho. Conectamos você ao veículo certo com uma curadoria inteligente e acompanhamento especializado do início ao fim.</p>
            {{-- Se tiver dados de contato reais, preencha abaixo, caso contrário pode remover esta div --}}
            {{-- <p class="mt-3"><strong>Email:</strong> <span>contato@alcecar.com.br</span></p> --}}
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Links Úteis</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('veiculos.novos')}}">Veículos Novos</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('veiculos.semi-novos')}}">Veículos Semi-novos</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('veiculos.usados')}}">Veículos Usados</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Lojista</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('login')}}">Área do lojista</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('anuncios.index') }}">Gerenciar anúncios</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          {{-- <h4>Nossa Newsletter</h4>
          <p>Assine nossa newsletter e receba as últimas ofertas e novidades do nosso estoque!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form">
                <input type="email" name="email" placeholder="Seu e-mail">
                <input type="submit" value="Inscrever">
            </div>
            <div class="loading">Carregando</div>
            <div class="error-message"></div>
            <div class="sent-message">Sua solicitação de inscrição foi enviada. Obrigado!</div>
          </form> --}}
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>{{ date('Y') }}</span> <strong class="px-1 sitename">Alcecar</strong> <span>Todos os direitos reservados</span></p>
      <div class="credits">
        Desenvolvido por <a href="https://pixdesign.com.br/">PixDesign</a>
      </div>
    </div>

</footer>