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
                    <li class="breadcrumb-item"><a href="{{ route('anuncios.index') }}">Anúncios</a></li>
                    <li class="breadcrumb-item active">Cadastrar veículo</li>
                </ol>
            </div>
            <h3 class="page-title">Cadastrar veículo</h3>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="row">
<div class="container">
    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-header bg-dark text-white p-4" style="border-radius: 15px 15px 0 0;">
            <h4 class="mb-0">Cadastro Manual de Veículo</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('anuncios.store-manual') }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="placa" class="form-control" placeholder="ABC1D23">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ano (Fabricação/Modelo)</label>
                        <input type="text" name="ano" class="form-control" placeholder="2020/2021">
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

                            <option value="NOVO">Novo</option>
                            <option value="SEMI-NOVO">Semi-novo</option>
                            <option value="USADO">Usado</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Kilometragem</label>
                        <input type="number" name="kilometragem" class="form-control">
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




                    <div class="col-md-12 mt-4">
                        <label class="form-label font-weight-bold">Fotos do Veículo</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">Selecione várias fotos de uma vez.</small>
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
</div>
@endsection