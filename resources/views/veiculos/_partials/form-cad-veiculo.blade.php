<div class="row">
    <div class="col-lg-12">
        <div class="mb-3">
            
        </div>
        <div class="mb-3">
            <label>Endereço: <span style="color: red;">*</span></label>
            <div class="col-lg">
                <div class="wrapper">
            <div class="container">
                <div class="upload-container">
                <div class="border-container text-center" id="drop-area">
                    <span class="text-center">Arraste e solte imagens aqui, ou 
                    <a href="#" id="file-browser">clique para escolher</a>
                    </span>
                    <input type="file" id="file-upload" name="images[]" multiple accept="image/*" hidden>
                </div>

                <!-- Área de preview -->
                <div id="previewContainer" class="d-flex flex-wrap mt-3 gap-2"></div>
                </div>
            </div>
        </div>
        <script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-upload');
    const fileBrowser = document.getElementById('file-browser');
    const previewContainer = document.getElementById('previewContainer');

    fileBrowser.addEventListener('click', function (e) {
        e.preventDefault();
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        handleFiles(this.files);
    });

    dropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropArea.classList.add('bg-light');
    });

    dropArea.addEventListener('dragleave', function () {
        dropArea.classList.remove('bg-light');
    });

    dropArea.addEventListener('drop', function (e) {
        e.preventDefault();
        dropArea.classList.remove('bg-light');
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
    previewContainer.innerHTML = ''; // limpa previews antigos

    Array.from(files).forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function (e) {
        const previewWrapper = document.createElement('div');
        previewWrapper.className = 'position-relative me-2 mb-2';

        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'preview-img';

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&times;';
        removeBtn.className = 'btn-remove-image';
        removeBtn.setAttribute('type', 'button');
        removeBtn.addEventListener('click', () => {
            previewWrapper.remove();
        });

        previewWrapper.appendChild(img);
        previewWrapper.appendChild(removeBtn);
        previewContainer.appendChild(previewWrapper);
        };
        reader.readAsDataURL(file);
    });
    }

    </script>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Câmbio: <span class="text-danger">*</span></label>
            <select name="cambio" class="form-select" required>
                <option value="" disabled selected>Selecione</option>
                <option value="Manual">Manual</option>
                <option value="Automático">Automático</option>
                <option value="CVT">CVT</option>
                <option value="Dualogic">Dualogic</option>
                <option value="Tiptronic">Tiptronic</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Portas: <span class="text-danger">*</span></label>
            <input type="text" name="portas" class="form-control" required />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Kilometragem: <span class="text-danger">*</span></label>
            <input type="text" name="kilometragem" class="form-control" required />
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Valor: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="valor" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Valor de oferta: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="valor_oferta" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true">
        </div>
    </div>
</div>

        
        <div class="mb-3">
            <label>CRLV Digital: <span style="color: red;">*</span></label>
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

