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

<div id="alerta-fipe-erro" class="alert alert-danger alert-dismissible bg-transparent d-none" role="alert">
     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    <i class="ri-error-warning-line me-2"></i>
    <strong>Atenção!</strong> O serviço da tabela FIPE está instável no momento. Estamos trabalhando no momento.
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
                        <select name="tipo" id="veiculo_tipo" class="form-control" required>
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
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Placa</label>
                        <input type="text" name="placa" class="form-control" placeholder="ABC1D23" style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Ano (Fabricação)</label>
                        <input type="text" name="ano_fabricacao" class="form-control" placeholder="2020" maxlength="9">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Ano (Modelo)</label>
                        <input type="text" name="ano_modelo" class="form-control" placeholder="2021" maxlength="9">
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
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        Cadastrar
                    </button>
                </div>
            </form>
                </div>
            </div>

        </div>
    </div>
</div>


<script>


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