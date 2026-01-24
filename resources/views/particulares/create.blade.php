@extends('particulares.layout.app')

@section('content')


{{-- Toasts de sessão --}}
@if (session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#fff',
        color: '#313a46',
    });

    @if (session('success'))
        Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif

    @if (session('error'))
        Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
    @endif
});
</script>
@endif

<style>
    /* Estilo Geral do Formulário */
    .form-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #ff4a17;
        box-shadow: 0 0 0 0.2rem rgba(255, 74, 23, 0.1);
        color: #212529;
    }

    /* Estilização dos Selects */
    select.form-control {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        appearance: none;
    }

    /* Divisores (HR) */
    hr {
        margin: 2rem 0;
        opacity: 0.1;
        border-top: 2px solid #000;
    }

    /* Checkboxes (Adicionais e Opcionais) */
    .form-check {
        margin-bottom: 10px;
        padding-left: 1.8em;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15em;
        margin-left: -1.8em;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #ff4a17;
        border-color: #ff4a17;
    }

    .form-check-label {
        font-size: 0.9rem;
        color: #6c757d;
        cursor: pointer;
        user-select: none;
    }

    /* Seções de Título Internas */
    .font-weight-bold {
        font-weight: 700 !important;
        color: #212529;
        font-size: 1rem;
    }

    /* Upload de Fotos */
    input[type="file"].form-control {
        padding: 8px;
        background: #fff;
    }

    /* Botões */
    .btn-primary {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px 30px;
        transition: transform 0.2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        background-color: #e33d0e !important;
    }

    .btn-light {
        background: #e9ecef;
        font-weight: 600;
        color: #495057;
    }

    /* Ajuste para Mobile */
    @media (max-width: 768px) {
        .col-md-2, .col-md-4 {
            margin-bottom: 10px;
        }
    }
</style>

{{-- Espaçador para evitar que o conteúdo fique sob a navbar fixa --}}
<div style="height: 100px;"></div>



 <section id="services" class="services section">

    {{-- Container do Formulário --}}
    <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            <div class="col-12">
                {{-- Card de Cadastro --}}
                <div class="shadow-sm border-0" style="border-radius: 15px; background: #fff; overflow: hidden;">
                    {{-- Cabeçalho --}}
                    <div class="bg-dark text-white p-4">
                        <h4 class="mb-0 fw-bold text-white"><i class="bi bi-car-front  me-2"></i>Cadastro de Veículo</h4>
                    </div>

                    {{-- Corpo --}}
                    <div class="p-4">
                        <p class="text-muted">Preencha as informações abaixo para publicar no Alcecar.</p>

                        <form action="{{ route('particulares.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-3">
                    <div class="col-md-4">
    <label class="form-label">Marca</label>
    <select name="marca_real" class="form-control" required>
        <option value="">Selecione a marca</option>

        <optgroup label="Marcas Mais Vendidas no Brasil">
            <option value="CHEVROLET">Chevrolet</option>
            <option value="VOLKSWAGEN">Volkswagen</option>
            <option value="FIAT">Fiat</option>
            <option value="FORD">Ford</option>
            <option value="TOYOTA">Toyota</option>
            <option value="HYUNDAI">Hyundai</option>
            <option value="RENAULT">Renault</option>
            <option value="HONDA">Honda</option>
            <option value="JEEP">Jeep</option>
            <option value="NISSAN">Nissan</option>
        </optgroup>

        <optgroup label="Outras Marcas Populares">
            <option value="PEUGEOT">Peugeot</option>
            <option value="CITROEN">Citroën</option>
            <option value="MITSUBISHI">Mitsubishi</option>
            <option value="KIA">Kia</option>
            <option value="SUZUKI">Suzuki</option>
            <option value="SUBARU">Subaru</option>
            <option value="JAC">JAC Motors</option>
        </optgroup>

        <optgroup label="Marcas Premium">
            <option value="BMW">BMW</option>
            <option value="MERCEDES-BENZ">Mercedes-Benz</option>
            <option value="AUDI">Audi</option>
            <option value="VOLVO">Volvo</option>
            <option value="LAND ROVER">Land Rover</option>
            <option value="PORSCHE">Porsche</option>
            <option value="MINI">Mini</option>
        </optgroup>

        <optgroup label="Elétricos e Novas Montadoras">
            <option value="BYD">BYD</option>
            <option value="CHERY">Chery</option>
            <option value="GWM">GWM</option>
            <option value="RAM">RAM</option>
        </optgroup>

    </select>
</div>

                    <div class="col-md-2">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="modelo_real" class="form-control" placeholder="GOL 1.0, CG 160 START...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tipo de veículo</label>
                        <select name="tipo"  class="form-control" required>
                            <option value="">Selecione o tipo</option>
                            <option value="AUTOMOVEL">Carro</option>
                            <option value="CAMINHONETE">Caminhonete</option>
                            <option value="MOTOCICLETA">Moto</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Placa</label>
                        <input type="text" name="placa" class="form-control" 
                            placeholder="ABC1D23" 
                            style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ano (Fabricação/Modelo)</label>
                        <input type="text" name="ano" id="input-ano" class="form-control" 
                            placeholder="2020/2021" maxlength="9">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Cor</label>
                        <input type="text" name="cor" class="form-control">
                    </div>


                    <div class="col-md-4">
                        <label class="form-label">Combustível</label>
                        <select name="combustivel" class="form-control" required>
                            <option value="">Selecione o combustível</option>

                            <option value="GASOLINA">Gasolina</option>
                            <option value="ETANOL">Etanol</option>
                            <option value="FLEX">Flex</option>
                            <option value="DIESEL">Diesel</option>
                            <option value="GNV">GNV</option>
                            <option value="ELETRICO">Elétrico</option>
                            <option value="HIBRIDO">Híbrido</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Condição do Veículo</label>
                        <select name="estado" class="form-control" required>
                            <option value="">Selecione a condição</option>

                            <option value="Novo">Novo</option>
                            <option value="Semi-novo">Semi-novo</option>
                            <option value="Usado">Usado</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Kilometragem</label>
                        <input type="text" name="kilometragem" id="kilometragem" class="form-control" placeholder="Ex: 54.000">
                    </div>



<div class="col-md-4">
<label for="categoria_especial" class="form-label text-muted">Categoria Especial</label>
                <select class="form-control" name="especiais" id="especiais">
                    <option value="" selected>Nenhuma (Padrão)</option>
                    <option value="Clássico">Clássico</option>
                    <option value="Esportivo">Esportivo</option>
                    <option value="Modificado">Modificado</option>
                </select>
                <small class="text-muted font-11">Opcional para veículos diferenciados.</small>
</div>
<div class="col-md-4">
    <label for="cambio" class="form-label text-muted">Câmbio</label>
                <select class="form-control" name="cambio" id="cambio" required>
                    <option value="" disabled>Selecione o câmbio</option>
                    <option value="Manual">Manual</option>
                    <option value="Automático">Automático</option>
                    <option value="CVT">CVT</option>
                </select>
</div>
<div class="col-md-4">
    <label for="portas" class="form-label text-muted">
                    Portas
                </label>
                
                <select class="form-control" name="portas" id="portas">
    <option value="">Selecione...</option> {{-- Adicionado para quando for moto --}}
    <option value="2">2 Portas</option>
    <option value="3">3 Portas</option>
    <option value="4">4 Portas</option>
    <option value="5">5 Portas</option>
</select>
</div>
<hr>
                    <div class="col-md-12 mt-3">
    <label class="form-label mb-3 fw-bold">Adicionais do Veículo</label>

    <div class="row g-3">
        @php
            // Lista de adicionais conforme seu trecho anterior
            $itensAdicionais = [
                "Aceita Troca", 
                "Adaptado para pessoas com deficiência", 
                "Consórcio", 
                "Garantia de Fábrica", 
                "IPVA Pago", 
                "Licenciado", 
                "Não aceita troca", 
                "Colecionador", 
                "Todas Revisões feitas", 
                "Único Dono", 
                "Veículo de Concessionária", 
                "Veículo Financiado"
            ];
            
            // Divide os 12 itens em 3 colunas de 4 itens cada
            $colunasAdicionais = array_chunk($itensAdicionais, ceil(count($itensAdicionais) / 3));
        @endphp

        @foreach($colunasAdicionais as $coluna)
            <div class="col-md-4">
                @foreach($coluna as $item)
                    @php
                        // Cria um ID amigável: "Único Dono" vira "adi_unico_dono"
                        $slugAdi = 'adi_' . Str::slug($item, '_');
                    @endphp
                    <div class="form-check mb-2">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="adicionais[]" 
                               value="{{ $item }}" 
                               id="{{ $slugAdi }}">
                        <label class="form-check-label small" for="{{ $slugAdi }}">
                            {{ $item }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

<hr>
<div class="col-md-12 mt-3">
    <label class="form-label mb-3 fw-bold">Opcionais do Veículo</label>

    <div class="row g-3" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
        @php
            $todosOpcionais = [
                "Air Bag", "Air Bag Cortina", "Air Bag Duplo", "Alarme", "Alerta colisão frontal", "Ar Condicionado", "Ar Condicionado Digital", "Ar Quente",
                "Banco com Aquecimento", "Banco de Couro", "Banco Elétrico", "Banco Recaro", "Banco Regulável Altura", "Cabine Dupla", "Cabine Estendida",
                "Cabine Simples", "Câmbio CVT", "Câmera de Ré", "Capota Marítima", "Chave Reserva",
                "Controle de Estabilidade", "Controle de Tração", "Desembaçador Traseiro", "Direção Elétrica", "Direção Escamoteável", "Direção Hidráulica", "Direção Multifuncional",
                "Engate para Reboque", "Estribo", "Farol Acendimento Aut.", "Farol Auxiliar", "Farol de LED", "Farol Regulagem Elétrica", "Freio de Mão Eletrônico",
                "Freios ABS", "Freios com EBD", "GPS", "Interface", "Legalizado", "Limpador Traseiro", "Lona Maritima", "Manual do proprietário", "Media Nav", "Monitor Pressão de Pneus",
                "Multimídia", "Parachoques na cor", "Park Assist", "Partida Elétrica", "Película Solar", "Piloto adaptativo", "Piloto Automatico",
                "Porta Malas Elétrico", "Protetor de Caçamba", "Protetor de Carter", "Quebra Mato", "Rack de teto", "Rádio com espelhamento celular", "Rádio u-connect", "Rastreador",
                "Rebaixado", "Retrovisor Elétrico", "Retrovisor Rebatimento Aut.", "Rodas de Liga Leve", "Santo Antônio", "Sensor de Chuva", "Sensor de Estacionamento",
                "Som no Volante", "Som Original", "Som Rádio",
                "Som Rádio CD", "Som Rádio DVD", "Som Rádio MP3", "Spoiler", "Start Stop", "Suspensão Regulável", "Teto Panoramico", "Teto Solar", "Tração 4x2", "Tração 4x4",
                "Tração AWD", "Travas Elétricas", "Turbo", "Vidros Elétricos", "Vidros Verdes", "Xenon"
            ];
            
            // Divide o array em 3 partes para as colunas
            $colunas = array_chunk($todosOpcionais, ceil(count($todosOpcionais) / 3));
        @endphp

        @foreach($colunas as $opcionaisColuna)
            <div class="col-md-4">
                @foreach($opcionaisColuna as $item)
                    @php
                        $slug = Str::slug($item, '_');
                    @endphp
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="opcionais[]" value="{{ $item }}" id="opc_{{ $slug }}">
                        <label class="form-check-label small" for="opc_{{ $slug }}">
                            {{ $item }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>


<hr>

                    <div class="col-md-12 mt-4">
                        <label class="form-label font-weight-bold">Fotos do Veículo</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">Selecione várias fotos de uma vez.</small>
                    </div>

                 <hr>

                     <div class="col-md-12 mt-4">
                        <label class="form-label font-weight-bold">Descrição</label>
                        <textarea class="form-control" name="descricao" id="" cols="30" rows="10"></textarea>
                    </div>

                 <hr>

                       <div class="row">
    <div class="col-md-6 mt-4">
        <label class="form-label text-muted">Valor de Venda (R$)</label>
        <input type="text" class="form-control form-control-lg money" name="valor" id="valor" placeholder="0,00" required>
    </div>

    <div class="col-md-6 mt-4">
        <label class="form-label text-muted">Valor de Oferta (Opcional - R$)</label>
        <input type="text" class="form-control form-control-lg money" name="valor_oferta" id="valor_oferta" placeholder="0,00">
        <small class="text-muted">Deixe vazio se não houver promoção.</small>
    </div>
</div>

                <div class="mt-5 d-flex justify-content-end gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5" style="background-color: #ff4a17; border: none;">
                        Finalizar Cadastro
                    </button>
                </div>
            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // 1. Função Autonoma para carregar bibliotecas e aplicar máscaras
    (function verificarBibliotecas() {
        if (typeof jQuery !== 'undefined' && typeof $.fn.mask !== 'undefined') {
            // Aplica a máscara em todos os campos monetários
            $('.money').mask('#.##0,00', {reverse: true});
            $('#input-ano').mask('0000/0000');
            $('input[name="placa"]').mask('AAAAAAA', {
                translation: {'A': { pattern: /[A-Za-z0-9]/ }},
                onKeyPress: function (v, e) { e.currentTarget.value = v.toUpperCase(); }
            });
            console.log("Máscaras Alcecar prontas.");
        } else {
            setTimeout(verificarBibliotecas, 100);
        }
    })();

    // 2. Comportamentos do Formulário
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica Moto vs Carro
        const selectTipo = document.querySelector('select[name="tipo"]');
        const selectPortas = document.querySelector('#portas');
        if (selectTipo && selectPortas) {
            const togglePortas = () => {
                const isMoto = selectTipo.value === 'MOTOCICLETA';
                selectPortas.disabled = isMoto;
                selectPortas.required = !isMoto;
                selectPortas.style.backgroundColor = isMoto ? "#e9ecef" : "#fff";
                if(isMoto) selectPortas.value = "";
            };
            selectTipo.addEventListener('change', togglePortas);
            togglePortas();
        }

        // Kilometragem (Apenas números)
        const inputKM = document.querySelector('#kilometragem');
        if (inputKM) {
            inputKM.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        }
    });
</script>
@endsection