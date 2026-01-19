@extends('loja.layout.app')

@section('title', 'Veículos')

@section('content')


 <section id="hero" class="hero section dark-background">
  <img src="{{ url('frontend/images/hero_bg_alcecar.jpg') }}" alt="" data-aos="fade-in">
  <div class="container d-flex flex-column align-items-center">
    
    <h2 data-aos="fade-up" data-aos-delay="100">Encontre o seu veículo</h2>
    <p data-aos="fade-up" data-aos-delay="200">Utilize a busca para encontrar o seu veículo</p>
    
    <div class="search-bar-wrapper mt-4" data-aos="fade-up" data-aos-delay="300">
      <div class="search-container-custom">
        <form action="{{ route('veiculos.search.geral') }}" method="GET" class="search-flex-container">

    <div class="dropdown custom-field">
        <input type="hidden" name="marca" id="input-marca">
        <button class="select-trigger" type="button" data-bs-toggle="dropdown">
            <span>Marca</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50"><path d="m6 9 6 6 6-6"></path></svg>
        </button>
        <div class="dropdown-menu custom-result-box-wrapper">
            <div class="scroll-arrow up">▲</div>
            <ul class="custom-result-box">
                @foreach($dadosAgrupados as $marca => $modelos)
                <li><button class="dropdown-item" type="button" data-value="{{ $marca }}">{{ $marca }}</button></li>
                @endforeach
            </ul>
            <div class="scroll-arrow down">▼</div>
        </div>
    </div>

    <div class="dropdown custom-field">
        <input type="hidden" name="modelo" id="input-modelo"> 
        <button class="select-trigger" type="button" data-bs-toggle="dropdown">
            <span class="text-muted">Modelo</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50"><path d="m6 9 6 6 6-6"></path></svg>
        </button>
        <div class="dropdown-menu custom-result-box-wrapper">
            <div class="scroll-arrow up">▲</div>
            <ul class="custom-result-box" id="lista-modelos">
                <li><span class="dropdown-item-text text-muted small">Selecione uma marca primeiro</span></li>
            </ul>
            <div class="scroll-arrow down">▼</div>
        </div>
    </div>

    <div class="dropdown custom-field">
        <input type="hidden" name="ano" id="input-ano">
        <button class="select-trigger" type="button" data-bs-toggle="dropdown">
            <span class="text-muted">Ano</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-50"><path d="m6 9 6 6 6-6"></path></svg>
        </button>
        <div class="dropdown-menu custom-result-box-wrapper">
            <div class="scroll-arrow up">▲</div>
            <ul class="custom-result-box">
                @for ($i = date('Y') + 1; $i >= 1970; $i--)
                    <li><button class="dropdown-item" type="button" data-value="{{ $i }}">{{ $i }}</button></li>
                @endfor
            </ul>
            <div class="scroll-arrow down">▼</div>
        </div>
    </div>

    <div class="dropdown custom-field">
        <input type="hidden" name="valor" id="input-preco">
        <button class="select-trigger" type="button" data-bs-toggle="dropdown">
            <span>Preço</span>
        </button>
        <div class="dropdown-menu custom-result-box-wrapper">
            <div class="scroll-arrow up">▲</div>
            <ul class="custom-result-box">
                <li><button class="dropdown-item" type="button" data-value="50000">Até R$ 50.000</button></li>
                <li><button class="dropdown-item" type="button" data-value="100000">Até R$ 100.000</button></li>
                <li><button class="dropdown-item" type="button" data-value="150000">Até R$ 150.000</button></li>
                <li><button class="dropdown-item" type="button" data-value="200000">Até R$ 200.000</button></li>
            </ul>
            <div class="scroll-arrow down">▼</div>
        </div>
    </div>

    <button type="submit" class="btn-search-purple">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
        <span>Buscar</span>
    </button>

</form>
      </div>
    </div>
  </div>
</section>


<script>
  document.addEventListener('DOMContentLoaded', function() {
  // Injeta os dados reais vindos do banco de dados através do Laravel
  const dadosVeiculos = {!! json_encode($dadosAgrupados) !!};

  const inputMarca = document.querySelector('#input-marca');
  const inputModelo = document.querySelector('#input-modelo');
  const dropdownModelo = inputModelo.closest('.dropdown');
  const spanModelo = dropdownModelo.querySelector('.select-trigger span');
  const listaModelosUl = dropdownModelo.querySelector('.custom-result-box');

  // --- Delegação de Eventos para Seleção ---
  document.addEventListener('click', function(e) {
    const item = e.target.closest('.dropdown-item');
    if (!item) return;

    const dropdown = item.closest('.custom-field');
    const displaySpan = dropdown.querySelector('.select-trigger span');
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');

    const selectedText = item.innerText.trim();
    const selectedValue = item.getAttribute('data-value');

    displaySpan.innerText = selectedText;
    displaySpan.style.color = "#333";
    
    if (hiddenInput) {
        hiddenInput.value = selectedValue;
        
        // Se for a marca, atualiza a lista de modelos reais
        if (hiddenInput.id === 'input-marca') {
            atualizarModelos(selectedValue);
        }
    }
  });

  function atualizarModelos(marcaSelecionada) {
    listaModelosUl.innerHTML = '';
    // Busca no objeto injetado
    const modelos = dadosVeiculos[marcaSelecionada];

    if (modelos && modelos.length > 0) {
        spanModelo.innerText = 'Selecione o Modelo'; 
        inputModelo.value = ''; 

        modelos.forEach(modelo => {
            const li = document.createElement('li');
            li.innerHTML = `<button class="dropdown-item" type="button" data-value="${modelo}">${modelo}</button>`;
            listaModelosUl.appendChild(li);
        });
    } else {
        listaModelosUl.innerHTML = '<li><span class="dropdown-item-text text-muted small">Sem modelos disponíveis</span></li>';
    }
  }

  // --- Lógica de Scroll Automático (Mantida) ---
  let scrollInterval;
  const scrollSpeed = 4;

  document.addEventListener('mouseover', function(e) {
    const seta = e.target.closest('.scroll-arrow');
    if (seta) {
      const container = seta.closest('.custom-result-box-wrapper').querySelector('.custom-result-box');
      const direction = seta.classList.contains('up') ? -1 : 1;
      stopScrolling();
      scrollInterval = setInterval(() => { container.scrollTop += direction * scrollSpeed; }, 10);
    }
  });

  document.addEventListener('mouseout', function(e) {
    if (e.target.closest('.scroll-arrow')) stopScrolling();
  });

  function stopScrolling() { clearInterval(scrollInterval); }
});
</script>
<section id="categories-overlap" class="categories-overlap">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 style="font-weight: 700; color: #333;">Encontre por Categoria</h2>
      <p style="color: #777;">Escolha o tipo de veículo que mais combina com você</p>
    </div>

    <div class="row g-4 row-cols-2 row-cols-lg-5 justify-content-center">
      
      <div class="col">
        <div class="category-card" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box">
            <img src="{{ url('frontend/images/categorias/hatch.png') }}" alt="Hatch" class="img-fluid">
          </div>
          <h4>HATCH</h4>
        </div>
      </div>

      <div class="col">
        <div class="category-card" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box">
            <img src="{{ url('frontend/images/categorias/sedan.png') }}" alt="Sedan" class="img-fluid">
          </div>
          <h4>SEDAN</h4>
        </div>
      </div>

      <div class="col">
        <div class="category-card" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box">
            <img src="{{ url('frontend/images/categorias/suv.png') }}" alt="SUV" class="img-fluid">
          </div>
          <h4>SUV</h4>
        </div>
      </div>

      <div class="col">
        <div class="category-card" data-aos="fade-up" data-aos-delay="400">
          <div class="icon-box">
            <img src="{{ url('frontend/images/categorias/pickup.png') }}" alt="Pick-up" class="img-fluid">
          </div>
          <h4>PICK-UP</h4>
        </div>
      </div>

      <div class="col">
        <div class="category-card" data-aos="fade-up" data-aos-delay="500">
          <div class="icon-box">
            <img src="{{ url('frontend/images/categorias/utilitario.png') }}" alt="Utilitário" class="img-fluid">
          </div>
          <h4>UTILITÁRIO</h4>
        </div>
      </div>

    </div>
  </div>
</section>

    <section id="services" class="services section">

  <div class="container section-title aos-init aos-animate" data-aos="fade-up">
    <h2>OFERTAS</h2>
    <p>Confira nossos veículos em destaque<br></p>
  </div>

  <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-5">

      @foreach ($veiculos as $veiculo)
        @php
            $imagens = json_decode($veiculo->images, true) ?? [];
            $imgUrl = count($imagens) ? asset('storage/' . $imagens[0]) : asset('assets/img/default-car.png');
        @endphp

        <div class="col-xl-4 col-md-6 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="200">
          <div class="service-item">
            
            {{-- Foto do Veículo --}}
            <div class="img">
              <img src="{{ $imgUrl }}" class="img-fluid" alt="{{ $veiculo->modelo_exibicao }}" style="width: 100%; height: 250px; object-fit: cover;">
            </div>

            <div class="details position-relative p-4">
    
    {{-- Topo: Marca e Badge de Estado --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="text-uppercase fw-bold text-muted" style="font-size: 12px; letter-spacing: 1px;">
            {{ $veiculo->marca_exibicao }}
        </span>
        <span class="badge {{ $veiculo->estado == 'Novo' ? 'bg-primary' : 'bg-dark' }} rounded-pill px-3" style="font-size: 10px;">
            {{ strtoupper($veiculo->estado) }}
        </span>
    </div>

    {{-- Título --}}
    <a href="{{ url('veiculo/' . $veiculo->slug) }}" class="stretched-link text-decoration-none">
        <h3 class="mb-3" style="color: #212529; font-weight: 700; font-size: 1.25rem; transition: 0.3s;">
            {{ $veiculo->modelo_exibicao }}
        </h3>
    </a>

    {{-- Informações Técnicas com Ícones (Grid) --}}
    <div class="row g-0 border-top border-bottom py-2 mb-3 text-muted" style="font-size: 13px;">
        <div class="col-4 border-end text-center">
            <i class="bi bi-speedometer2 d-block mb-1"></i>
            {{ number_format($veiculo->kilometragem, 0, ',', '.') }} km
        </div>
        <div class="col-4 border-end text-center">
            <i class="bi bi-calendar3 d-block mb-1"></i>
            {{ $veiculo->ano }}
        </div>
        <div class="col-4 text-center">
            <i class="bi bi-gear-wide-connected d-block mb-1"></i>
            {{ $veiculo->cambio }}
        </div>
    </div>

    {{-- Área de Preço --}}
    <div class="d-flex justify-content-between align-items-end mt-3">
    
    {{-- Lado Esquerdo: Preços --}}
    <div class="price-box d-flex flex-column justify-content-end align-items-start">
        @if($veiculo->valor_oferta && $veiculo->valor_oferta < $veiculo->valor)
            <span class="text-muted text-decoration-line-through mb-0" style="font-size: 0.8rem;">
                R$ {{ number_format($veiculo->valor, 2, ',', '.') }}
            </span>
            <div class="fw-bold text-success" style="font-size: 1.5rem; line-height: 1;">
                <span style="font-size: 0.9rem;">R$</span> {{ number_format($veiculo->valor_oferta, 2, ',', '.') }}
            </div>
        @else
            <div class="fw-bold text-dark" style="font-size: 1.5rem; line-height: 1;">
                <span style="font-size: 0.9rem;">R$</span> {{ number_format($veiculo->valor, 2, ',', '.') }}
            </div>
        @endif
    </div>

    {{-- Lado Direito: Botão de Detalhes --}}
    <div class="action-button" style="position: relative; z-index: 2;">
        {{-- O z-index garante que o clique no botão funcione de forma independente do stretched-link --}}
        <a href="{{ url('veiculo/' . $veiculo->slug) }}" 
           class="btn btn-outline-get-started d-flex align-items-center gap-2" 
           style="border-radius: 50px; padding: 8px 18px; font-size: 12px; font-weight: 700; transition: 0.3s; border-width: 2px;">
            DETALHES
            <i class="bi bi-arrow-right-short" style="font-size: 1.2rem; line-height: 0;"></i>
        </a>
    </div>

</div>
</div>
          </div>
        </div>@endforeach

    </div>
  </div>

</section>
    

    <section id="features" class="features section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
  <div class="features-item" style="display: flex; justify-content: center;">
    <img src="{{ url('frontend/images/marcas/logo-audi.webp') }}" alt="">
  </div>
</div>


          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-bmw.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-chevrolet.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-fiat.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-ford.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-honda.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-hyundai.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-nissan.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="900">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-peugeot.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1000">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-renault.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1100">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-toyota.webp') }}" alt="">
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1200">
            <div class="features-item" style="display: flex; justify-content: center;">
              <img src="{{ url('frontend/images/marcas/logo-volkswagen.webp') }}" alt="">
            </div>
          </div>

        </div>

      </div>

    </section>

    
    <style>
:root {
    --accent-color-why: #ff4a17; /* Laranja Alcecar */
    --accent-light-why: rgba(255, 74, 23, 0.1);
}

.section-title-why {
    color: #48315a; /* Roxo escuro do print */
    font-weight: 700;
    font-size: 2.5rem;
}

/* Imagem limpa e grande */
.image-container-clean {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-container-clean img {
    width: 100%; /* Força a imagem a ocupar toda a largura da coluna */
    max-width: 500px; /* Limite para não estourar em telas ultra-wide */
    height: auto;
    object-fit: contain;
    /* Removido sombras pesadas e fundos */
}

/* Estilo dos Cards */
.feature-card-why {
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    height: 100%;
    border: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.feature-card-why:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}

.icon-box-why {
    width: 50px;
    height: 50px;
    background-color: var(--accent-light-why);
    color: var(--accent-color-why);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 15px;
}

.feature-card-why h3 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: #1a1a1a;
}

.feature-card-why p {
    font-size: 0.9rem;
    color: #6c757d;
    line-height: 1.5;
    margin-bottom: 0;
}
</style>

<section class="why-choose-section py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5 section-title-why">Porque escolher a Alcecar?</h2>

        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <div class="image-container-clean">
                    <img src="{{ url('frontend/images/header_app.png') }}" alt="NetCarros App" class="img-fluid">
                </div>
            </div>

            <div class="col-lg-7">
                <div class="row g-4">
    <div class="col-md-6">
        <div class="feature-card-why">
            <div class="icon-box-why"><i class="bi bi-lightning-charge"></i></div>
            <h3>Cadastro Rápido</h3>
            <p>Anuncie em segundos. Nossa interface intuitiva permite cadastrar veículos com poucos cliques, otimizando o seu tempo de venda.</p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="feature-card-why">
            <div class="icon-box-why"><i class="bi bi-kanban"></i></div>
            <h3>Gestão de Veículos</h3>
            <p>Tenha controle total do seu estoque. Monitore status, fotos e informações técnicas de forma organizada e centralizada.</p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="feature-card-why">
            <div class="icon-box-why"><i class="bi bi-folder-check"></i></div>
            <h3>Documentação Organizada</h3>
            <p>Armazene e acesse documentos de transferência e vistorias digitalmente, eliminando a papelada e o risco de perdas.</p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="feature-card-why">
            <div class="icon-box-why"><i class="bi bi-file-earmark-text"></i></div>
            <h3>Procurações Automáticas</h3>
            <p>Gere procurações e contratos personalizados instantaneamente com os dados do sistema, prontos para impressão ou assinatura.</p>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</section>
    @endsection