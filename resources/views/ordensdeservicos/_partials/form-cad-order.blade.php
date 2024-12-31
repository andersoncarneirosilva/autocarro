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

            e.target.value = value;
        });
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
                                    <input type="text" class="form-control" data-provide="typeahead" id="cliente-search" placeholder="Selecione o cliente">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Marca: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="marca" id="marca" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Placa: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="placa" id="placa" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Chassi: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="chassi" id="chassi" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Cor: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="cor" id="cor" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Ano/Modelo: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="ano_modelo" id="ano_modelo" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Renavam: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="renavam" id="renavam" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>       
                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('procuracoes.index')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                            <button type="button" onclick="form.reset();" class="btn btn-warning btn-sm">Limpar</button>
                            <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
        
    </div>
    
</div>

