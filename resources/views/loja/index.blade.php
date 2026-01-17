@extends('loja.layout.app')

@section('title', 'Veículos')

@section('content')

<style>
    .home-index-bg {
        /* O SVG cria o arco vinho */
        background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='5700' height='400' ><circle fill='%235b0000' cx='2325' cy='-6098' r='6457'/></svg>");
        
        background-position: center top;
        background-repeat: no-repeat;
        background-size: 330% auto;
        padding-top: 80px;
        padding-bottom: 120px;
        min-height: 450px;
        display: flex;
        align-items: center; /* Centraliza verticalmente o conteúdo no arco */
    }

    /* Centraliza o texto e define largura máxima */
    .home-index-bg h1 {
        font-size: 2.2rem;
        line-height: 1.2;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .search-box {
        background: #fff;
        padding: 10px 15px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 650px;
        margin: 30px auto 0 auto; /* Centraliza a barra horizontalmente */
        text-align: left; /* Mantém o texto dentro do input alinhado à esquerda */
    }

    .search-box-keyword {
        flex: 1;
        padding-left: 20px;
    }

    .search-box-label {
        font-size: 14px;
        font-weight: bold;
        color: #730000;
        margin-bottom: -5px;
    }

    .search-box input {
        border: none !important;
        padding: 0;
        height: auto;
        box-shadow: none !important;
        font-size: 16px;
        width: 100%;
    }

    .btn-primary {
        background-color: #730000 !important;
        border-color: #730000 !important;
        border-radius: 30px !important;
        font-weight: bold;
        padding: 12px 40px !important;
        color: #fff !important;
        text-decoration: none;
    }

    #resultsList {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    background: #fff;
    margin-top: 2px;
}

.suggest-item {
    cursor: pointer;
    padding: 10px 15px;
    font-size: 14px;
}

.suggest-item:hover {
    background-color: #f8f9fa;
    color: #007bff;
}
</style>
<div class="home-index-bg">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 text-center">
                
                <h1 class="h2 font-weight-bold text-white mb-20">
                    Encontre o seu próximo carro agora, <br> 
                    explore nosso estoque com as melhores ofertas.
                </h1>
                
                <form action="{{ route('veiculos.search.geral') }}" method="GET" id="formBuscaGeral">
                    <div class="search-box" style="position: relative;">
                        <div class="search-box-keyword">
                            <div class="search-box-label">O que você busca?</div>
                            <div class="form-group mt-1">
                                <input autocomplete="off" type="text" class="form-control" 
                                       placeholder="Digite a marca ou modelo do veículo" 
                                       id="txtMarcaCar" name="termo">
                                
                                <div id="resultsList" class="list-group shadow" 
                                     style="position: absolute; width: 100%; z-index: 1000; display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="search-box-btn">
                            <button type="submit" class="btn btn-primary" id="btnBuscar">
                                <span class="btn-text">BUSCAR</span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let timeout = null;

    $('#txtMarcaCar').on('keyup', function() {
        clearTimeout(timeout);
        let busca = $(this).val();
        let $resultsList = $('#resultsList');

        if (busca.length < 2) {
            $resultsList.hide().empty();
            return;
        }

        timeout = setTimeout(function() {
            $.ajax({
                url: '/sugestoes',
                method: 'GET',
                data: { termo: busca },
                success: function(data) {
                    $resultsList.empty();

                    if (data.length > 0) {
                        data.forEach(function(item) {
                            // Exibe marca e modelo para facilitar a escolha
                            let textoExibicao = item.marca_real + ' ' + item.modelo_real;
                            // O valor enviado para a busca será o modelo_real
                            let valorBusca = item.modelo_real;

                            $resultsList.append(`
                                <a href="#" class="list-group-item list-group-item-action suggest-item" data-value="${valorBusca}">
                                    ${textoExibicao}
                                </a>
                            `);
                        });
                        $resultsList.show();
                    } else {
                        $resultsList.hide();
                    }
                }
            });
        }, 300);
    });

    // Ao clicar em uma sugestão: preenche e já envia a busca
    $(document).on('click', '.suggest-item', function(e) {
        e.preventDefault();
        let valor = $(this).data('value');
        $('#txtMarcaCar').val(valor);
        $('#resultsList').hide();
        
        // Envia o formulário automaticamente ao selecionar
        $('#formBuscaGeral').submit();
    });

    // Fecha a lista se clicar fora do campo de busca
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-box').length) {
            $('#resultsList').hide();
        }
    });
});
</script>

    <section id="why-us" class="section why-us">
  <div class="container">
    <div class="row gy-4">

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="why-box">
          <h3>Por que comprar conosco?</h3>
          <p>
            Oferecemos uma ampla variedade de veículos — carros, motos e utilitários — com procedência, garantia e preços justos. Aqui você encontra qualidade, confiança e um atendimento diferenciado do início ao fim da sua compra.
          </p>
          <div class="text-center">
            <a href="#estoque" class="more-btn"><span>Saiba mais</span> <i class="bi bi-chevron-right"></i></a>
          </div>
        </div>
      </div><!-- End Why Box -->

      <div class="col-lg-8 d-flex align-items-stretch">
        <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

          <div class="col-xl-4">
            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
              <i class="bi bi-clipboard-data"></i>
              <h4>Veículos revisados</h4>
              <p>Todos os veículos passam por vistoria e revisão completa antes de irem para o nosso estoque.</p>
            </div>
          </div><!-- End Icon Box -->

          <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
              <i class="bi bi-gem"></i>
              <h4>Garantia e procedência</h4>
              <p>Trabalhamos apenas com veículos com documentação em dia e histórico transparente.</p>
            </div>
          </div><!-- End Icon Box -->

          <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
              <i class="bi bi-inboxes"></i>
              <h4>Financiamento facilitado</h4>
              <p>Parceria com os principais bancos para oferecer as melhores condições de pagamento.</p>
            </div>
          </div><!-- End Icon Box -->

        </div>
      </div>

    </div>
  </div>
</section>


    <!-- Features Section -->
    <section id="features" class="features section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
  <div class="features-item" style="display: flex; justify-content: center;">
    <img src="site/img/marcas/audi.webp" alt="">
  </div>
</div>


          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/bmw.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/chevrolet.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/fiat.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/ford.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/honda.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/hyundai.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/nissan.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="900">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/peugeot.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1000">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/renault.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1100">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/toyota.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1200">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="site/img/marcas/volkswagem.webp" alt="">
            </div>
          </div><!-- End Feature Item -->

        </div>

      </div>

    </section><!-- /Features Section -->

    <style>
      /* CARD */
.course-item {
    background: #fff;
    border-radius: 6px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* CONTAINER FIXO DA IMAGEM */
.course-image {
    position: relative;
    width: 100%;
    height: 230px; /* 🔥 ALTURA ÚNICA PARA TODOS */
    overflow: hidden;
}

/* CAROUSEL OCUPA TUDO */
.course-image .carousel,
.course-image .carousel-inner,
.course-image .carousel-item {
    height: 100%;
}

/* IMAGEM */
.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* 🔥 ESSENCIAL */
}

/* CONTEÚDO DO CARD */
.course-content {
    padding: 15px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

    </style>
    <section id="courses" class="courses section">

      <div class="container section-title" data-aos="fade-up">
        <h2>OFERTAS</h2>
        <p>Mais vendidos</p>
      </div>

      <div class="container">

        <div class="row">

          @foreach ($veiculos as $veiculo)
<div class="col-lg-4 col-md-6 mb-4 d-flex" data-aos="zoom-in" data-aos-delay="100">
    <div class="course-item w-100">

        @php
            $imagens = json_decode($veiculo->images, true) ?? [];
        @endphp

        {{-- IMAGEM --}}
        <div class="course-image">
    <img
        src="{{ count($imagens)
            ? asset('storage/' . $imagens[0])
            : asset('assets/img/default-car.png') }}"
        alt="Imagem do veículo"
    >
</div>


        {{-- CONTEÚDO --}}
        <div class="course-content">

            <div class="d-flex justify-content-between mb-2">
                <span class="badge bg-light text-dark">{{ $veiculo->marca_exibicao }}</span>
                <span class="badge bg-success">{{ $veiculo->estado }}</span>
            </div>

            <h5 class="mb-1">{{ $veiculo->modelo_exibicao }}</h5>

            <p class="text-muted mb-3" style="font-size: 14px;">
                {{ $veiculo->kilometragem }} km • {{ $veiculo->ano }} • {{ $veiculo->cambio }}
            </p>

            <div class="mt-auto d-flex justify-content-between align-items-center">

                <a href="{{ url('sistema/veiculo/' . $veiculo->slug) }}"
                   class="btn btn-outline-success btn-sm">
                    + DETALHES
                </a>

                <div class="text-end">
                    @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
                        <small class="text-muted text-decoration-line-through">
                            R$ {{ number_format($veiculo->valor, 2, ',', '.') }}
                        </small>
                        <div class="fw-bold fs-5">
                            R$ {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}
                        </div>
                    @else
                        <div class="fw-bold fs-5">
                            R$ {{ number_format($veiculo->valor, 2, ',', '.') }}
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</div>
@endforeach


        </div>

      </div>

    </section>

    @endsection