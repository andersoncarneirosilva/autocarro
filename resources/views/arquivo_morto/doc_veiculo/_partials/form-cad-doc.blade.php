<h4 class="header-title">Informações pessoais</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label">Nome</label>
                            <select class="form-select" name="colaborador" id="usuario">
                                <option value="">Selecione o colaborador</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->name }}" data-price="{{ $user->email }}" data-img="{{ $user->image }}">{{ $user->name }}</option>    
                                @endforeach
                              </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label">Categoria</label>
                            <select class="form-select" name="documento" id="categoria">
                                <option value="">Selecione o documento</option>
                                @foreach ($categorias as $cats)
                                    <option value="{{ $cats->nome_doc }}">{{ $cats->nome_doc }}</option>    
                                @endforeach
                            </select>
                        </div>
                        <!-- Subcategoria -->
                        <div class="mb-3">
                            <label>Subcategoria</label>
                            <select class="form-select" name="subdocumento" id="subdocumento">
                                <option value="">Selecione a subcategoria</option>
                            </select>
                        </div>
                    </div>
                    <script type="text/javascript">
                        window.onload = function() {
                            const currentDate = new Date();
                            const data = new Date();
                            // Formata a data em 6 dígitos
                            const formattedDate = currentDate.toLocaleDateString();
                            const resultMes = String(data.getMonth() + 1).padStart(2, '0');
                            
                            // Acessa o input com o ID "data"
                            const input = document.getElementById('inputdata');
                            // Atribui o valor formatado ao input
                            const getMes = document.getElementById('inputmes');
                            

                            getMes.value =  resultMes;
                            //console.log(resultMes);
                            input.value = formattedDate;

                        }
                        </script>
                    <input type="hidden" id="inputdata" name="date">
                    <input type="hidden" id="inputmes" name="numeromes" value="">
                    <input type="hidden" name="status" value="A confirmar">
                    <input type="hidden" name="foto" id="idImage">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label">Documento</label>
                            <div class="col-lg">
                                <input class="form-control" type="file" name="arquivo">
                            </div>
                        </div>
                    </div>
                    
                </div>
                <script>
                    $('#usuario').on('change',function(){
                    var price = $(this).children('option:selected').data('price');
                    $('#idEmail').val(price);
                });
                </script>
                <script>
                    $('#usuario').on('change',function(){
                    var img = $(this).children('option:selected').data('img');
                    $('#idImage').val(img);
                });
                </script>

                <br>
                <div class="row">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </div>

                <script>
                    document.getElementById('categoria').addEventListener('change', function() {
                        var categoriaSelecionada = this.value;
                        //console.log(categoriaSelecionada);
                        fetch('{{ route("obtersubcategorias") }}?nome_cat=' + categoriaSelecionada)
                            .then(function(response) {
                                return response.json();
                            })
                            .then(function(data) {
                                //console.log(data); // Verifique a estrutura dos dados retornados
                
                                var subcategoriaSelect = document.getElementById('subdocumento');
                                subcategoriaSelect.innerHTML = ''; // Limpa as opções existentes
                
                                // Adiciona a opção padrão
                                var defaultOption = document.createElement('option');
                                defaultOption.value = '';
                                defaultOption.textContent = 'Selecione a subcategoria';
                                subcategoriaSelect.appendChild(defaultOption);
                
                                // Adiciona as opções de subcategoria
                                data.forEach(function(subcategoria) {
                                    var option = document.createElement('option');
                                    option.value = subcategoria.nome_subcat;
                                    option.textContent = subcategoria.nome_subcat; // Atribui o nome da subcategoria ao texto do option
                                    subcategoriaSelect.appendChild(option);
                                });
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    });
                </script>