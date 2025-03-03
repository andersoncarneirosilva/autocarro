<div class="row">
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
                <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc" required>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary" id="submitButton">Cadastrar</button>
        <!-- Botão com Spinner (Oculto por padrão) -->
        <button class="btn btn-primary" id="loadingButton" type="button" disabled style="display: none;">
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            Cadastrando...
        </button>
    </div>
</div>

