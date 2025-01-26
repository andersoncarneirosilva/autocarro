<h4 class="header-title">Informações pessoais</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label">Nome</label>
                            <select class="form-select" name="colaborador" id="usuario">
                                <option value="">Selecione o colaborador</option>
                                <option value="Todos">Todos</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->name }}" data-price="{{ $user->email }}" data-img="{{ $user->image }}">{{ $user->name }}</option>    
                                @endforeach
                                
                                
                              </select>
                        </div>
                    </div>
                            <input type="hidden" class="form-control" name="email" id="idEmail">

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label">Mês referente</label>
                            <select class="form-select" name="mes">
                                <option value="">Selecione o colaborador</option>
                                <option value="Janeiro">Janeiro</option>
                                <option value="Fevereiro">Fevereiro</option>
                                <option value="Março">Março</option>
                                <option value="Abril">Abril</option>
                                <option value="Maio">Maio</option>
                                <option value="Junho">Junho</option>
                                <option value="Julho">Julho</option>
                                <option value="Agosto">Agosto</option>
                                <option value="Setembro">Setembro</option>
                                <option value="Outubro">Outubro</option>
                                <option value="Novembro">Novembro</option>
                                <option value="Dezembro">Dezembro</option>
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
                            console.log(formattedDate);
                            input.value = formattedDate;

                        }
                        </script>
                    <input type="hidden" name="status" value="PENDENTE">
                    <input type="hidden" id="inputdata" name="date">
                    <input type="hidden" id="inputmes" name="numeromes" value="">
                    <input type="hidden" name="class_status" value="badge badge-outline-warning">
                    <input type="hidden" name="foto" id="idImage">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label">Contracheque</label>
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