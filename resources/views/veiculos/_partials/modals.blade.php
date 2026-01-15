<!-- GERAR PROCURACAO -->
<div class="modal fade" id="procModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gerar procuração</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="procForm" method="POST">
                    @csrf <!-- Necessário para o Laravel validar a requisição -->
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Endereço: <span style="color: red;">*</span></label>
                            <div class="col-lg">
                                <select id="idCliente" name="cliente[]" class="form-control"
                            placeholder="Selecione o cliente">
                            <option value="">Selecione o cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->endereco }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                            </div>
                        </div>
                    </div>
                    <br>

                    <input type="hidden" id="docId" name="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="submitProc()">Gerar</button>
            </div>
        </div>
    </div>
</div>

<!-- GERAR ATPVE -->   
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Gerar solicitação ATPVe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="addressForm" method="POST" class="needs-validation" novalidate>
                    @csrf <!-- Necessário para o Laravel validar a requisição -->
                    <div class="form-group">
                        <label for="outorgado">Selecione o outorgado: <span style="color: red;">*</span></label>
                        <select id="outorgado" name="outorgado" class="form-control"
                            placeholder="Selecione o outorgado">
                            <option value="">Selecione o outorgado</option>
                            @foreach ($outorgados as $outorgado)
                                <option value="{{ $outorgado->id }}"
                                    data-nome="{{ $outorgado->nome_outorgado }}"
                                    data-cpf="{{ $outorgado->cpf_outorgado }}"
                                    data-email="{{ $outorgado->email_outorgado }}">
                                    {{ $outorgado->nome_outorgado }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="nome_outorgado" name="nome_outorgado" value="">
                        <input type="hidden" id="email_outorgado" name="email_outorgado" value="">
                        <input type="hidden" id="cpf_outorgado" name="cpf_outorgado" value="">
                        <script>
                            document.getElementById('outorgado').addEventListener('change', function() {
                                const selectedOption = this.options[this.selectedIndex];
                                document.getElementById('nome_outorgado').value = selectedOption.getAttribute('data-nome') || '';
                                document.getElementById('email_outorgado').value = selectedOption.getAttribute('data-email') || '';
                                document.getElementById('cpf_outorgado').value = selectedOption.getAttribute('data-cpf') || '';
                            });
                        </script>

                    </div>
                    <br>
                    <div class="form-group">
                        <label for="">Selecione o cliente: <span style="color: red;">*</span></label>
                        <select id="idCliente" name="cliente[]" class="form-control"
                            placeholder="Selecione o cliente">
                            <option value="">Selecione o cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <br>
                    <!-- Campo adicional para valor -->

                    <div class="form-group">
                        <label for="valor">Valor: <span style="color: red;">*</span></label>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="text" class="form-control" id="valor" name="valor"
                                placeholder="Insira o valor" required>
                        </div>

                    </div>
                    <input type="hidden" id="docId" name="docId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="submitAddress()">Gerar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Procuração -->
<div class="modal fade" id="modalProcuracao" tabindex="-1" aria-labelledby="modalProcuracaoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProcuracaoLabel">Enviar Procuração Assinada</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted mb-2 mt-2">Selecione a procuração assinada:</p>
          <input class="form-control" type="file" name="arquivo_proc_assinado" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal ATPVe -->
<div class="modal fade" id="modalAtpve" tabindex="-1" aria-labelledby="modalAtpveLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAtpveLabel">Enviar Solicitação ATPVe Assinada</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted mb-2 mt-2">Selecione a solicitação atpve assinada:</p>
          <input class="form-control" type="file" name="arquivo_atpve_assinado" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Modal Adicionar Fotos -->
<div class="modal fade" id="modalAdicionarFoto" tabindex="-1" aria-labelledby="modalAdicionarFotoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('veiculos.adicionarFotos', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdicionarFotoLabel">Adicionar Fotos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <input type="file" name="fotos[]" multiple class="form-control" accept="image/*" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
        </div>
    </form>
  </div>
</div>


<!-- Modal CRLV -->
<div class="modal fade" id="crlvModal" tabindex="-1" aria-labelledby="modalProcuracaoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="docForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProcuracaoLabel">Enviar novo CRLV</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted mb-2 mt-2">Selecione o novo documento:</p>
          <input class="form-control" type="file" name="arquivo_doc" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="submitCrlv()">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</div>
