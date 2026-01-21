<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadProc" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Outorgado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('modeloprocuracoes.store') }}" id="outorgadosForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Selecione os Outorgados: <span style="color: red;">*</span></label>
                        <select class="select2 form-control select2-multiple" id="outorgadosSelect"  data-toggle="select2" multiple="multiple" name="outorgados[]" data-placeholder="Escolha um ou mais ..." required>
                            <option value="">Selecione o cliente</option>
                            @foreach ($outorgados as $out)
                                <option value="{{ $out->id }}">{{ $out->nome_outorgado }}</option>
                            @endforeach
                        </select>
                    </div>  
                    <div class="form-group">
                        <label for="texto_inicial">Texto Inicial: <span style="color: red;">*</span></label>
                        <textarea name="texto_inicial"  class="form-control"  rows="5" required></textarea>
                    </div>   
                    <div class="form-group">
                        <label for="texto_inicial">Texto Final: <span style="color: red;">*</span></label>
                        <textarea name="texto_final" class="form-control" rows="5" required></textarea>
                    </div>  
                    <div class="form-group">
                        <label for="nome_outorgado" class="form-label">Cidade: <span style="color: red;">*</span></label>
                        <input class="form-control" name="cidade" required/>
                    </div>         
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>