{{-- BUSCAR CLIENTES --}}
<script>
$(document).ready(function () {
    // Inicializa o Bloodhound para buscar os clientes
    var clientes = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nome'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/ordensdeservicos/buscar?query=%QUERY', // Rota que processa a busca
            wildcard: '%QUERY'
        }
    });

    // Inicializa o Typeahead para o campo de busca
    $('#cliente-search').typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'clientes',
            display: 'nome',
            source: clientes,
            templates: {
                empty: [
                    '<div class="typeahead-empty-message">',
                    'Nenhum cliente encontrado.',
                    '</div>'
                ].join('\n'),
                suggestion: function (data) {
                    return '<div>' + data.nome + ' - ' + data.email + '</div>';
                }
            }
        }
    ).on('typeahead:select', function (event, data) {
        // Quando o cliente é selecionado, atualiza o campo CPF
        $('#cpf').val(data.cpf);
        $('#cep').val(data.cep);
        $('#rua').val(data.endereco);
        $('#numero').val(data.numero);
        $('#bairro').val(data.bairro);
        $('#cidade').val(data.cidade);
        $('#uf').val(data.estado);
        $('#cliente_id').val(data.id);
    });
});
</script>

<script>
    $(document).ready(function() {
        // Inicializa o select2
        $('.select2').select2();

        // Função para formatar valores em reais
        function formatarReal(valor) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(valor);
        }

        // Função para extrair valores numéricos de strings formatadas
        function extrairNumero(valor) {
            return parseFloat(valor.replace(/[^\d,.-]/g, '').replace(',', '.')) || 0;
        }

        // Função para atualizar o valor total
        function atualizarValorTotal() {
            const valorServico = extrairNumero($('#valor_servico').val());
            const taxaServico = extrairNumero($('#taxa_servico').val());
            const valorTotal = valorServico + taxaServico;

            $('#valor_total').val(formatarReal(valorTotal));
        }

        // Evento de mudança no select
        $('#idCliente').on('change', function() {
            let totalValor = 0;
            let totalTaxa = 0;

            // Itera por todas as opções selecionadas
            $(this).find('option:selected').each(function() {
                const valorServico = parseFloat($(this).data('valor')) || 0;
                const taxaServico = parseFloat($(this).data('taxa')) || 0;

                // Soma os valores
                totalValor += valorServico;
                totalTaxa += taxaServico;
            });

            // Atualiza os campos com os valores somados e formatados
            $('#valor_servico').val(formatarReal(totalValor));
            $('#taxa_servico').val(formatarReal(totalTaxa));

            // Atualiza o valor total
            atualizarValorTotal();
        });

        // Eventos de input nos campos de valor e taxa
        $('#valor_servico, #taxa_servico').on('input', function() {
            atualizarValorTotal();
        });
    });
</script>

<script>
$(document).ready(function () {
    // Função para preencher os campos com os dados do veículo selecionado
    $('#idVeiculo').on('change', function () {
        const selectedOption = $(this).find('option:selected'); // Obtém a opção selecionada
        const veiculoId = $(this).val(); // Obtém o value (ID do veículo)

        // Verifica se existe uma seleção válida
        if (selectedOption.length > 0) {
            const nome = selectedOption.data('nome') || '';
            const marca = selectedOption.data('marca') || '';
            const ano = selectedOption.data('ano') || '';
            const cor = selectedOption.data('cor') || '';
            const cidade = selectedOption.data('cidade') || '';

            // Preenche os campos com os dados
            $('#proprietario').val(nome);
            $('#marca').val(marca);
            $('#ano').val(ano);
            $('#cor').val(cor);
            $('#cidade_veiculo').val(cidade);
            $('#documento_id').val(veiculoId); // Preenche o campo com o ID do veículo
        } else {
            // Limpa os campos caso nenhuma opção seja selecionada
            $('#proprietario').val('');
            $('#marca').val('');
            $('#ano').val('');
            $('#cor').val('');
            $('#cidade_veiculo').val('');
            $('#documento_id').val(''); // Limpa o campo de ID do veículo
        }
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cpf').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cep').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 8) value = value.slice(0, 8); // Limita ao tamanho do CEP

            // Adiciona o ponto e o hífen no formato 00.000-000
            value = value.replace(/(\d{2})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,3})$/, '$1-$2');

            e.target.value = value;buscarservicos
        });
    });
</script>
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label">Cliente <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" data-provide="typeahead" id="cliente-search" name="nome_cliente" placeholder="Selecione o cliente">
                                </div>                                   
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPF: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="cpf" id="cpf" maxlength="14" required>
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <div class="row">
                        <div class="col-md">
                            <div class="mb-2">
                                <label for="social-fb" class="form-label">CEP: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value);" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="social-fb" class="form-label">Logradouro: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="endereco" id="rua" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="social-insta" class="form-label">Número: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="numero" id="numero" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Bairro: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="bairro" id="bairro" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Cidade: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="cidade" id="cidade" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Estado: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="estado" id="uf" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Informações do veículo</h5>
                    <div class="row">
                        <div class="col-md">
                            <div class="mb-2">
                                <label class="form-label">Placa <span style="color: red;">*</span></label>
                                <select class="js-example-basic-single" name="veiculo[]" id="idVeiculo" data-placeholder="Selecione o veículo">
                                    <option value="">Selecione a placa</option>
                                    @foreach ($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}" data-nome="{{ $veiculo->nome }}" data-marca="{{ $veiculo->marca }}" data-ano="{{ $veiculo->ano }}" data-cor="{{ $veiculo->cor }}" data-cidade="{{ $veiculo->cidade }}">
                                        {{ $veiculo->placa }}
                                    </option>
                                    @endforeach
                                  </select>
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Proprietário:</label>
                                <div class="input-group">
                                    <input type="text" name="estproprietarioado" id="proprietario" class="form-control form-control-sm" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="social-fb" class="form-label">Marca:</label>
                                <div class="input-group">
                                    <input type="text" name="marca" id="marca" class="form-control form-control-sm" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Ano/Modelo:</label>
                                <div class="input-group">
                                    <input type="text" name="ano" id="ano" class="form-control form-control-sm" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="social-insta" class="form-label">Cor:</label>
                                <div class="input-group">
                                    <input type="text" name="cor" id="cor" class="form-control form-control-sm" readonly/>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Cidade:</label>
                                <div class="input-group">
                                    <input type="text" name="cidade" id="cidade_veiculo" class="form-control form-control-sm" readonly/>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Informações do serviço</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo de serviço: <span style="color: red;">*</span></label>
                                <select class="select2 form-control select2-multiple" name="tipo_servico[]" id="idCliente" data-toggle="select2" multiple="multiple" >
                                    <option value="">Selecione o serviço</option>
                                    @foreach ($servicos as $servico)
                                        <option value="{{ $servico->nome_servico }}" data-valor="{{ $servico->valor_servico }}" data-taxa="{{ $servico->taxa_servico }}">
                                            {{ $servico->nome_servico }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Valor do serviço:</label>
                                <div class="input-group">
                                    <input type="text" name="valor_servico" id="valor_servico" class="form-control form-control-sm" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Taxa administrativa:</label>
                                <div class="input-group">
                                    <input type="text" name="taxa_servico" id="taxa_servico" class="form-control form-control-sm" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Valor total:</label>
                                <div class="input-group">
                                    <input type="text" name="valor_total" id="valor_total" class="form-control form-control-sm" required/>
                                </div>
                            </div>
                        </div>
                        

                       
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="social-insta" class="form-label">Descrição do serviço: <span style="color: red;">*</span></label>
                            <textarea class="form-control" name="servico" id="servico" cols="30" rows="5"></textarea>   
                        </div> 
                    </div>
                    <br>    
                    <!-- CAMPOS HIDDEN -->
                    <input type="hidden" name="classe_status" value="badge badge-outline-warning"/>
                    <input type="hidden" name="status" value="PENDENTE"/>
                    <input type="hidden" name="cliente_id" id="cliente_id" value=""/>
                    <input type="text" name="documento_id" id="documento_id" value=""/>



                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('ordensdeservicos.index')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
        
    </div>
    
</div>

