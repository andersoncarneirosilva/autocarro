<div class="row">
    <div class="col-md-8 px-md-3">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <h4 class="header-title text-primary mb-0">
                <i class="mdi mdi-car-info me-1"></i> Ficha do Veículo
            </h4>
            <button type="button" class="btn btn-outline-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditarInfoVeiculo">
                <i class="mdi mdi-sync me-1"></i> Atualizar Dados
            </button>
        </div>

                <div class="bg-light p-3 rounded d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <small class="text-muted fw-bold text-uppercase font-11 tracking-wider">Veículo</small>
                        <h3 class="mt-1 mb-0 text-primary">{{ $veiculo->marca }} <span class="text-dark">{{ $veiculo->modelo }}</span></h3>
                        <p class="text-muted font-14 mb-0">{{ $veiculo->versao }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary px-2 py-1 mb-1 d-block">
                            <i class="mdi mdi-calendar me-1"></i>{{ $veiculo->ano_fabricacao }}/{{ $veiculo->ano_modelo }}
                        </span>
                        <span class="badge badge-soft-primary border border-primary border-opacity-10 d-block">
                            <i class="mdi mdi-gas-station me-1"></i>{{ $veiculo->combustivel }}
                        </span>
                    </div>
                </div>
            <div class="card border shadow-none mb-4">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-4 g-3">
                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Placa</small>
                        <span class="font-15 fw-semibold text-dark">{{ $veiculo->placa }}</span>
                    </div>

                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Cor</small>
                        <span class="font-15 text-dark fw-bold">
                            <i class="mdi mdi-palette-outline me-1 text-primary"></i>{{ $veiculo->cor }}
                        </span>
                    </div>

                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Câmbio</small>
                        <span class="font-15 text-dark fw-bold">
                            <i class="mdi mdi-car-shift-pattern me-1 text-primary"></i>{{ $veiculo->cambio ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Kilometragem</small>
                        <span class="font-15 text-dark fw-bold">
                            <i class="mdi mdi-speedometer me-1 text-primary"></i>{{ number_format($veiculo->kilometragem, 0, ',', '.') }} KM
                        </span>
                    </div>

                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Estrutura</small>
                        @if(str_contains(strtolower($veiculo->tipo), 'moto'))
                            <span class="font-15 fw-semibold text-dark">MOTO</span>
                        @else
                            <span class="font-15 fw-semibold text-dark"><i class="mdi mdi-car-door me-1 text-primary"></i>{{ $veiculo->portas }} Portas</span>
                        @endif
                    </div>

                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Combustível</small>
                        <span class="font-15 text-dark fw-bold">
                            <i class="mdi mdi-speedometer me-1 text-primary"></i>{{ $veiculo->combustivel }} KM
                        </span>
                    </div>

                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Ano Fabricação</small>
                        <span class="font-15 text-dark fw-bold">
                            <i class="mdi mdi-calendar-month-outline me-1 text-primary"></i>{{ $veiculo->ano_fabricacao ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="col-md-3 col-6">
                        <small class="text-muted d-block font-11 fw-bold text-uppercase">Ano Modelo</small>
                        <span class="font-15 text-dark fw-bold">
                            <i class="mdi mdi-calendar-star me-1 text-primary"></i>{{ $veiculo->ano_modelo ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
            </div>
    </div>

    <div class="col-md-4 border-start ps-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="header-title text-primary mb-0">Galeria</h4>
            <button type="button" class="btn btn-outline-primary btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUploadFotos">
                <i class="mdi mdi-camera-plus me-1"></i> Adicionar
            </button>
        </div>
        
        @php $imagens = json_decode($veiculo->images); @endphp
                            
        <div class="position-relative border rounded p-1 bg-white shadow-sm mb-3">
            @if(!empty($imagens))
                <div id="carouselVeiculo" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        @foreach($imagens as $key => $img)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}" class="d-block w-100 rounded" style="aspect-ratio: 4/3; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    @if(count($imagens) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselVeiculo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 250px;">
                    <i class="mdi mdi-image-off text-muted font-24"></i>
                </div>
            @endif
        </div>

        <div class="row g-1 mt-1 ms-0 me-0">
    @if(!empty($imagens))
        @foreach($imagens as $key => $img)
            <div class="col-2 p-0 pe-1 mb-1"> {{-- Controle de espaçamento manual mais preciso --}}
                <img src="{{ asset('storage/' . $img) }}" 
                     class="img-fluid rounded border thumbnail-wrapper cursor-pointer shadow-sm" 
                     onclick="$('#carouselVeiculo').carousel({{ $key }})"
                     {{-- Reduzi o height para 40px para acompanhar o tamanho reduzido que você pediu anteriormente --}}
                     style="height: 40px; width: 100%; object-fit: cover; display: block;">
            </div>
        @endforeach
    @endif
</div>
    </div>
</div>
<style>
    /* Garante que a row não tente expandir além do pai */
    .row.ms-0.me-0 {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    
    .thumbnail-wrapper {
        transition: all 0.2s;
        border: 1px solid #dee2e6;
    }

    .thumbnail-wrapper:hover {
        border-color: #727cf5 !important;
        opacity: 0.8;
    }
</style>
<style>
    .font-11 { font-size: 11px; }
    .font-14 { font-size: 14px; }
    .font-15 { font-size: 15px; }
    .badge-soft-primary { background: rgba(114, 124, 245, 0.1); color: #727cf5; }
    .badge-soft-warning { background: rgba(249, 188, 80, 0.15); color: #f9bc50; }
    .thumbnail-wrapper { cursor: pointer; transition: 0.2s; opacity: 0.7; }
    .thumbnail-wrapper:hover { opacity: 1; border-color: #727cf5 !important; transform: scale(1.05); }
    .italic { font-style: italic; }
</style>