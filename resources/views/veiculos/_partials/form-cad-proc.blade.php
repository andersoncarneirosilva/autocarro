<div class="row">
    <div class="col-lg-12">
        <div class="mb-3">
            <label>Selecione o Outorgado: <span style="color: red;">*</span></label>
            <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" name="outorgados[]" data-placeholder="Escolha um ou mais ...">
                <option value="">Selecione o cliente</option>
                @foreach ($outorgados as $out)
                    <option value="{{ $out->id }}">{{ $out->nome_outorgado }}</option>
                @endforeach
            </select>
            
                                                            
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3">
            <label>Endereço: <span style="color: red;">*</span></label>
            <div class="col-lg">
                <input class="form-control" type="text" name="endereco" required>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="mb-3">
            <label>Documento: <span style="color: red;">*</span></label>
            <div class="col-lg">
                <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc">
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </div>
</div>