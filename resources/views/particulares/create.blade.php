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
                
                <input type="hidden" name="marca_nome" id="marca_nome">
<input type="hidden" name="modelo_nome" id="modelo_nome">
<input type="hidden" name="versao_nome" id="versao_nome">

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tipo de veículo</label>
                        <select name="tipo"  class="form-control" required>
                            <option value="">Selecione o tipo</option>
                            <option value="AUTOMOVEL">Carro</option>
                            <option value="MOTOCICLETA">Moto</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Marca</label>
                        <select name="marca_real" id="marca" class="form-control">
                            <option value="">Selecione</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Modelo</label>
                        <select name="modelo_real" id="modelo_carro" class="form-control" required disabled>
                            <option value="">Selecione a marca</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Versão</label>
                        <select name="versao" id="versao" class="form-control" required disabled>
                            <option value="">Selecione o modelo</option>
                        </select>
                    </div>
                </div>
                    <div class="row g-2">
                    
                    <div class="col-md-3">
                        <label class="form-label">Placa</label>
                        <input type="text" name="placa" class="form-control" 
                            placeholder="ABC1D23" 
                            style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ano (Fabricação/Modelo)</label>
                        <input type="text" name="ano" id="input-ano" class="form-control" 
                            placeholder="2020/2021" maxlength="9">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Cor</label>
                        <input type="text" name="cor" class="form-control">
                    </div>


                    <div class="col-md-3">
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
                    </div>

<div class="row g-2">
                    




<div class="col-md-3">
    <label for="cambio" class="form-label text-muted">Câmbio</label>
                <select class="form-control" name="cambio" id="cambio" required>
                    <option value="" disabled>Selecione o câmbio</option>
                    <option value="Manual">Manual</option>
                    <option value="Automático">Automático</option>
                    <option value="CVT">CVT</option>
                </select>
</div>
<div class="col-md-3">
    <label for="portas" class="form-label text-muted">Portas</label>
                <select class="form-control" name="portas" id="portas">
    <option value="" disabled selected>Selecione...</option>
    <option value="2">2 Portas</option>
    <option value="3">3 Portas</option>
    <option value="4">4 Portas</option>
    <option value="5">5 Portas</option>
</select>
</div>
<div class="col-md-3">
                        <label class="form-label">Kilometragem</label>
                        <input type="text" name="kilometragem" id="kilometragem" class="form-control" placeholder="Ex: 54.000">
                    </div>
                    <div class="col-md-3">
    <label for="portas" class="form-label text-muted">Portas</label>
                <select class="form-control" name="modelo_carro" id="portas">
    <option value="" disabled selected>Selecione a categoria</option>
    <option value="HATCH">HATCH</option>
    <option value="SEDAN">SEDAN</option>
    <option value="SUV">SUV</option>
    <option value="PICK-UP">PICK-UP</option>
    <option value="UTILITÁRIO">UTILITÁRIO</option>
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


<script>

document.addEventListener('DOMContentLoaded', function() {
    const selectTipo = document.querySelector('select[name="tipo"]');
    const selectMarca = document.getElementById('marca');
    const selectModelo = document.getElementById('modelo_carro');
    const selectVersao = document.getElementById('versao');
    const inputAno = document.getElementById('input-ano');
    const selectCombustivel = document.querySelector('select[name="combustivel"]');

    // Função auxiliar para definir a rota da API com base no seu HTML
    function getTipoRota() {
        const valor = selectTipo.value;
        if (valor === 'MOTOCICLETA') return 'motos';
        return 'carros'; // Para AUTOMOVEL e CAMINHONETE
    }

    const BASE_URL = 'https://parallelum.com.br/fipe/api/v1';

    // 1. Ao mudar o TIPO, carrega as MARCAS
    selectTipo.addEventListener('change', function() {
        const tipo = getTipoRota();
        
        // Reseta todos os campos subsequentes
        selectMarca.innerHTML = '<option value="">Carregando...</option>';
        selectModelo.innerHTML = '<option value="">Selecione a marca</option>';
        selectVersao.innerHTML = '<option value="">Selecione o modelo</option>';
        selectModelo.disabled = true;
        selectVersao.disabled = true;

        if (this.value) {
            fetch(`${BASE_URL}/${tipo}/marcas`)
                .then(response => response.json())
                .then(marcas => {
                    selectMarca.innerHTML = '<option value="">Selecione a Marca</option>';
                    marcas.forEach(marca => {
                        const opt = document.createElement('option');
                        opt.value = marca.codigo;
                        opt.textContent = marca.nome;
                        selectMarca.appendChild(opt);
                    });
                })
                .catch(err => console.error("Erro ao carregar marcas", err));
        }
    });

    // 2. Ao mudar a MARCA, carrega os MODELOS
    
    // 1. Ao mudar a MARCA
selectMarca.addEventListener('change', function() {
    const tipo = getTipoRota();
    const marcaId = this.value;
    
    // Captura o NOME da marca selecionada
    const marcaNome = this.options[this.selectedIndex].text;
    document.getElementById('marca_nome').value = marcaNome;

    selectModelo.innerHTML = '<option value="">Carregando...</option>';
    selectVersao.innerHTML = '<option value="">Selecione o modelo</option>';
    selectModelo.disabled = true;
    selectVersao.disabled = true;

    if (marcaId) {
        fetch(`${BASE_URL}/${tipo}/marcas/${marcaId}/modelos`)
            .then(response => response.json())
            .then(data => {
                selectModelo.innerHTML = '<option value="">Selecione o Modelo</option>';
                data.modelos.forEach(modelo => {
                    const opt = document.createElement('option');
                    opt.value = modelo.codigo;
                    opt.textContent = modelo.nome;
                    selectModelo.appendChild(opt);
                });
                selectModelo.disabled = false;
            });
    }
});

// 2. Ao mudar o MODELO
selectModelo.addEventListener('change', function() {
    const tipo = getTipoRota();
    const marcaId = selectMarca.value;
    const modeloId = this.value;
    
    // Captura o NOME do modelo selecionado
    const modeloNome = this.options[this.selectedIndex].text;
    document.getElementById('modelo_nome').value = modeloNome;

    selectVersao.innerHTML = '<option value="">Carregando...</option>';
    selectVersao.disabled = true;

    if (modeloId) {
        fetch(`${BASE_URL}/${tipo}/marcas/${marcaId}/modelos/${modeloId}/anos`)
            .then(response => response.json())
            .then(anos => {
                selectVersao.innerHTML = '<option value="">Selecione a Versão</option>';
                anos.forEach(ano => {
                    const opt = document.createElement('option');
                    opt.value = ano.codigo;
                    opt.textContent = ano.nome;
                    selectVersao.appendChild(opt);
                });
                selectVersao.disabled = false;
            });
    }
});

// 3. Ao selecionar a VERSÃO
selectVersao.addEventListener('change', function() {
    const tipo = getTipoRota();
    const marcaId = selectMarca.value;
    const modeloId = selectModelo.value;
    const anoId = this.value;
    
    // Captura o NOME da versão/ano selecionado
    const versaoNome = this.options[this.selectedIndex].text;
    document.getElementById('versao_nome').value = versaoNome;

    if (anoId) {
        fetch(`${BASE_URL}/${tipo}/marcas/${marcaId}/modelos/${modeloId}/anos/${anoId}`)
            .then(response => response.json())
            .then(veiculo => {
                // Preenche o Ano (Ex: 2023/2023)
                if(inputAno) inputAno.value = `${veiculo.AnoModelo}/${veiculo.AnoModelo}`;

                // Tenta selecionar o combustível automaticamente
                if(selectCombustivel) {
                    const fipeComb = veiculo.Combustivel.toUpperCase();
                    Array.from(selectCombustivel.options).forEach(opt => {
                        if (fipeComb.includes(opt.value)) {
                            opt.selected = true;
                        }
                    });

                    // Lógica Extra: Se for Elétrico ou Híbrido, coloca câmbio Automático
                    const selectCambio = document.getElementById('cambio');
                    if (fipeComb.includes('ELÉTRICO') || fipeComb.includes('HÍBRIDO')) {
                        if (selectCambio) selectCambio.value = 'Automático';
                    }
                }
            });
    }
});
});

</script>



@endsection