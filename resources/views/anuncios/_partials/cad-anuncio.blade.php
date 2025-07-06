<div class="row">
  <!-- Coluna esquerda - Upload e preview -->
  <div class="col-md-4">
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="mb-3 text-uppercase bg-light p-2">Imagens do veículo</h5>

        <div class="wrapper">
            <div class="container">
                <div class="upload-container">
                <div class="border-container" id="drop-area">
                    <div class="icons fa-4x text-center mb-3">
                    <i class="fas fa-file-image" data-fa-transform="shrink-3 down-2 left-6 rotate--45"></i>
                    <i class="fas fa-file-alt" data-fa-transform="shrink-2 up-4"></i>
                    <i class="fas fa-file-pdf" data-fa-transform="shrink-3 down-2 right-6 rotate-45"></i>
                    </div>
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

  <!-- Coluna direita - Formulário -->
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Informações do veículo</h5>

        <div class="row">
          <!-- Formulário como está no seu exemplo, mantido intacto -->
          <!-- (vou omitir aqui por espaço, você pode colar o seu conteúdo completo do formulário) -->

          <!-- Exemplo de um campo -->
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Marca: <span class="text-danger">*</span></label>
              <input type="text" name="marca" class="form-control" required />
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Modelo: <span class="text-danger">*</span></label>
              <input type="text" name="modelo" class="form-control" required />
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Ano: <span class="text-danger">*</span></label>
              <input type="text" name="ano" class="form-control" required />
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Kilometragem: <span class="text-danger">*</span></label>
              <input type="text" name="kilometragem" class="form-control" required />
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Cor: <span class="text-danger">*</span></label>
              <input type="text" name="cor" class="form-control" required />
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Câmbio: <span class="text-danger">*</span></label>
                <select name="cambio" class="form-select" required>
                <option value="" disabled selected>Selecione</option>
                <option value="Manual">Manual</option>
                <option value="Automático">Automático</option>
                <option value="Automatizado">Automatizado</option>
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
                <label class="form-label">Combustível: <span class="text-danger">*</span></label>
                <select name="combustivel" class="form-select" required>
                <option value="" disabled selected>Selecione</option>
                <option value="Gasolina">Gasolina</option>
                <option value="Etanol">Etanol</option>
                <option value="Flex">Flex</option>
                <option value="Diesel">Diesel</option>
                <option value="GNV">GNV</option>
                <option value="Elétrico">Elétrico</option>
                <option value="Híbrido">Híbrido</option>
                </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Valor: <span class="text-danger">*</span></label>
              <input type="text" name="valor" class="form-control" required />
            </div>
          </div>

        

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Detalhes: <span class="text-danger">*</span></label>
                    <textarea name="observacoes" class="form-control" id="" cols="30" rows="5"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
          <div class="col-lg-6"></div>
          <div class="col-lg-6 text-end">
            <a href="{{ route('veiculos.index') }}" class="btn btn-secondary btn-sm">Voltar</a>
            <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
