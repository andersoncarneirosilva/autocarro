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
                    <div class="col-md-12">
    <label class="form-label mb-2">Adicionais do Veículo</label>

    <div class="row">
        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="ACEITA_TROCA" id="adicional_aceita_troca">
                <label class="form-check-label" for="adicional_aceita_troca">Aceita Troca</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="PCD" id="adicional_pcd">
                <label class="form-check-label" for="adicional_pcd">Adaptado para pessoas com deficiência</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="CONSORCIO" id="adicional_consorcio">
                <label class="form-check-label" for="adicional_consorcio">Consórcio</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="GARANTIA_FABRICA" id="adicional_garantia">
                <label class="form-check-label" for="adicional_garantia">Garantia de Fábrica</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="IPVA_PAGO" id="adicional_ipva">
                <label class="form-check-label" for="adicional_ipva">IPVA Pago</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="LICENCIADO" id="adicional_licenciado">
                <label class="form-check-label" for="adicional_licenciado">Licenciado</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="NAO_ACEITA_TROCA" id="adicional_nao_troca">
                <label class="form-check-label" for="adicional_nao_troca">Não aceita troca</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="COLECIONADOR" id="adicional_colecionador">
                <label class="form-check-label" for="adicional_colecionador">Peça de Colecionador</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="REVISOES_EM_DIA" id="adicional_revisoes">
                <label class="form-check-label" for="adicional_revisoes">Todas Revisões feitas</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="UNICO_DONO" id="adicional_unico_dono">
                <label class="form-check-label" for="adicional_unico_dono">Único Dono</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="CONCESSIONARIA" id="adicional_concessionaria">
                <label class="form-check-label" for="adicional_concessionaria">Veículo de Concessionária</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="adicionais[]" value="FINANCIADO" id="adicional_financiado">
                <label class="form-check-label" for="adicional_financiado">Veículo Financiado</label>
            </div>
        </div>
    </div>
</div>

<hr>
<div class="col-md-12 mt-3">
    <label class="form-label mb-2">Opcionais do Veículo</label>

    <div class="row">
        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="AIRBAG" id="opcional_airbag">
                <label class="form-check-label" for="opcional_airbag">Air Bag</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="AIRBAG_DUPLO" id="opcional_airbag_duplo">
                <label class="form-check-label" for="opcional_airbag_duplo">Air Bag Duplo</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="ALARME" id="opcional_alarme">
                <label class="form-check-label" for="opcional_alarme">Alarme</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="BLINDADO" id="opcional_blindado">
                <label class="form-check-label" for="opcional_blindado">Blindado</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="SENSOR_ESTACIONAMENTO" id="opcional_sensor">
                <label class="form-check-label" for="opcional_sensor">Sensor de Estacionamento</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="BANCO_COURO" id="opcional_banco_couro">
                <label class="form-check-label" for="opcional_banco_couro">Banco de Couro</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="BANCO_RECARO" id="opcional_banco_recaro">
                <label class="form-check-label" for="opcional_banco_recaro">Banco Recaro</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="PADDLE_SHIFT" id="opcional_paddle">
                <label class="form-check-label" for="opcional_paddle">Paddle Shift / Borboleta</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="TETO_SOLAR" id="opcional_teto_solar">
                <label class="form-check-label" for="opcional_teto_solar">Teto Solar</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="ENGATE_REBOQUE" id="opcional_engate">
                <label class="form-check-label" for="opcional_engate">Engate para Reboque</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="FAROL_AUXILIAR" id="opcional_farol_aux">
                <label class="form-check-label" for="opcional_farol_aux">Farol Auxiliar</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="FAROL_LED" id="opcional_farol_led">
                <label class="form-check-label" for="opcional_farol_led">Farol de LED</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="RODAS_LIGA_LEVE" id="opcional_rodas">
                <label class="form-check-label" for="opcional_rodas">Rodas de Liga Leve</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="SANTO_ANTONIO" id="opcional_santo_antonio">
                <label class="form-check-label" for="opcional_santo_antonio">Santo Antônio</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="SPOILER" id="opcional_spoiler">
                <label class="form-check-label" for="opcional_spoiler">Spoiler</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="XENON" id="opcional_xenon">
                <label class="form-check-label" for="opcional_xenon">Xenon</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcionais[]" value="PELICULA_SOLAR" id="opcional_pelicula">
                <label class="form-check-label" for="opcional_pelicula">Película Solar</label>
            </div>
        </div>
    </div>
</div>


<hr>

                    <div class="col-md-12 mt-4">
                        <label class="form-label font-weight-bold">Fotos do Veículo</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">Selecione várias fotos de uma vez.</small>
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