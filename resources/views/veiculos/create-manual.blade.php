@extends('layouts.app')

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

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('veiculos.index') }}">Veículos</a></li>
                    <li class="breadcrumb-item active">Cadastrar veículo</li>
                </ol>
            </div>
            <h3 class="page-title">Cadastrar veículo</h3>
        </div>
    </div>
</div>

<div class="container-fluid p-0"> <div class="row g-0"> <div class="col-12">
            
            <div class="card border-0" style="border-radius: 0;"> 
                <div class="card-header bg-dark text-white p-4" style="border-radius: 0;">
                    <h4 class="mb-0"><i class="fas fa-car me-2"></i>Cadastro Manual de Veículo</h4>
                </div>
                
                <div class="card-body p-4 p-md-5"> 
                    <form action="{{ route('veiculos.store-manual') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="marca_nome" id="marca_nome">
                <input type="hidden" name="modelo_nome" id="modelo_nome">
                <input type="hidden" name="versao_nome" id="versao_nome">

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo de veículo</label>
                        <select name="tipo" class="form-control" required>
                            <option value="">Selecione o tipo</option>
                            <option value="AUTOMOVEL">Carro</option>
                            <option value="MOTOCICLETA">Moto</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Marca</label>
                        <select name="marca_real" id="marca" class="form-control" required>
                            <option value="">Selecione</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Modelo</label>
                        <select name="modelo_real" id="modelo_carro" class="form-control" required disabled>
                            <option value="">Selecione a marca</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Versão</label>
                        <select name="versao" id="versao" class="form-control" required disabled>
                            <option value="">Selecione o modelo</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Placa</label>
                        <input type="text" name="placa" class="form-control" placeholder="ABC1D23" style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Ano (Fab/Mod)</label>
                        <input type="text" name="ano" id="input-ano" class="form-control" placeholder="2020/2021" maxlength="9">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cor</label>
                        <input type="text" name="cor" class="form-control" placeholder="Ex: Branco">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Combustível</label>
                        <select name="combustivel" class="form-control" required>
                            <option value="">Selecione...</option>
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

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Câmbio</label>
                        <select class="form-control" name="cambio" id="cambio" required>
                            <option value="" disabled selected>Selecione...</option>
                            <option value="Manual">Manual</option>
                            <option value="Automático">Automático</option>
                            <option value="CVT">CVT</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Portas</label>
                        <select class="form-control" name="portas" id="portas">
                            <option value="" disabled selected>Selecione...</option>
                            <option value="2">2 Portas</option>
                            <option value="3">3 Portas</option>
                            <option value="4">4 Portas</option>
                            <option value="5">5 Portas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Kilometragem</label>
                        <input type="text" name="kilometragem" id="kilometragem" class="form-control" placeholder="Ex: 54.000">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Categoria</label>
                        <select class="form-control" name="modelo_carro" id="categoria_veiculo">
                            <option value="" disabled selected>Selecione...</option>
                            <option value="HATCH">HATCH</option>
                            <option value="SEDAN">SEDAN</option>
                            <option value="SUV">SUV</option>
                            <option value="PICK-UP">PICK-UP</option>
                            <option value="UTILITÁRIO">UTILITÁRIO</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="col-md-12 mb-4">
                    <label class="form-label mb-3 fw-bold text-primary">Adicionais do Veículo</label>
                    <div class="row g-3">
                        @php
                            $itensAdicionais = ["Aceita Troca", "Adaptado para PCD", "Consórcio", "Garantia de Fábrica", "IPVA Pago", "Licenciado", "Não aceita troca", "Colecionador", "Todas Revisões feitas", "Único Dono", "Veículo de Concessionária", "Veículo Financiado"];
                            $colunasAdicionais = array_chunk($itensAdicionais, ceil(count($itensAdicionais) / 3));
                        @endphp
                        @foreach($colunasAdicionais as $coluna)
                            <div class="col-md-4">
                                @foreach($coluna as $item)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="adicionais[]" value="{{ $item }}" id="adi_{{ Str::slug($item, '_') }}">
                                        <label class="form-check-label small" for="adi_{{ Str::slug($item, '_') }}">{{ $item }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="my-4">

                <div class="col-md-12 mb-4">
                    <label class="form-label mb-3 fw-bold text-primary">Opcionais do Veículo</label>
                    <div class="row g-3 px-2" style="max-height: 350px; overflow-y: auto; border: 1px solid #eee; padding: 15px; border-radius: 10px;">
                        @php
                            $todosOpcionais = ["Air Bag", "Alarme", "Ar Condicionado", "Ar Condicionado Digital", "Banco de Couro", "Banco Elétrico", "Câmera de Ré", "Central Multimídia", "Chave Reserva", "Controle de Estabilidade", "Direção Elétrica", "Direção Hidráulica", "Farol de LED", "Freios ABS", "Piloto Automático", "Retrovisor Elétrico", "Rodas de Liga Leve", "Sensor de Estacionamento", "Teto Solar", "Travas Elétricas", "Vidros Elétricos"];
                            $colunas = array_chunk($todosOpcionais, ceil(count($todosOpcionais) / 3));
                        @endphp
                        @foreach($colunas as $opcionaisColuna)
                            <div class="col-md-4">
                                @foreach($opcionaisColuna as $item)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="opcionais[]" value="{{ $item }}" id="opc_{{ Str::slug($item, '_') }}">
                                        <label class="form-check-label small" for="opc_{{ Str::slug($item, '_') }}">{{ $item }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Fotos do Veículo</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Descrição do Anúncio</label>
                    <textarea class="form-control" name="descricao" rows="5" placeholder="Detalhe o estado do veículo, revisões, etc..."></textarea>
                </div>

                <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Valor de Venda (R$)</label>
                        <input type="text" class="form-control form-control-lg money" name="valor" placeholder="0,00" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Valor de Oferta (Opcional)</label>
                        <input type="text" class="form-control form-control-lg money" name="valor_oferta" placeholder="0,00">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="{{ url()->previous() }}" class="btn btn-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm" style="background-color: #ff4a17; border: none; font-weight: bold;">
                        PUBLICAR ANÚNCIO
                    </button>
                </div>
            </form>
                </div>
            </div>

        </div>
    </div>
</div>


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