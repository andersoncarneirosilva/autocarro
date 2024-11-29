

<h4 class="header-title">Informações pessoais</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label">Colaborador: <span class="red" style="color: red;">*</span></label>
                            <select class="form-select" name="colaborador" id="usuario">
                                <option value="">Selecione o colaborador</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->name }}" data-price="{{ $user->email }}" data-img="{{ $user->image }}">{{ $user->name }}</option>    
                                @endforeach
                              </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="valor-total">Valor total da compra: <span class="red" style="color: red;">*</span></label>
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-btn input-group-prepend"></span>
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </span>
                                <input data-toggle="touchspin" type="text"  name="total" class="form-control" id="valor-total">
                                <span class="input-group-btn input-group-append">
                                    </span>
                                </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="numero-parcelas">Número de parcelas: <span class="red" style="color: red;">*</span></label>
                            <select id="numero-parcelas" class="form-select" name="qt_parcela" onchange="calcularParcelas()">
                            <option value="1">1x</option>
                            <option value="2">2x</option>
                            <option value="3">3x</option>
                            <option value="4">4x</option>
                            <option value="5">5x</option>
                            <option value="6">6x</option>
                        </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="valor-total">Valor de cada parcela:</label>
                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                            <span class="input-group-btn input-group-prepend"></span>
                            <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                <span class="input-group-text">R$</span>
                            </span>
                            <input data-toggle="touchspin" type="text" id="valor-parcela" name="parcela" class="form-control" readonly>
                            <span class="input-group-btn input-group-append">
                                </span>
                            </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data de vencimento: <span class="red" style="color: red;">*</span></label>
                        <input type="date" class="form-control flatpickr-input active"  name="data_vencimento">
                    </div>
                    <div class="mb-3">
                        <label">Motivo do emprestimo: <span class="red" style="color: red;">*</span></label>
                        <input type="text"  name="motivo" class="form-control">
                    </div>
                      
                      <script>
                      function calcularParcelas() {
                        const valorTotal = document.getElementById('valor-total').value;
                        const numeroParcelas = document.getElementById('numero-parcelas').value;
                        const valorParcela = valorTotal / numeroParcelas;
                        document.getElementById('valor-parcela').value = valorParcela.toFixed(2);
                      }
                      </script>
                    
                    <input type="hidden" class="form-control" name="email" id="idEmail">
                    <input type="hidden" class="form-control" name="class_status" value="badge badge-outline-warning">
                    <input type="hidden" class="form-control" name="status" value="PENDENTE">
                    
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

                