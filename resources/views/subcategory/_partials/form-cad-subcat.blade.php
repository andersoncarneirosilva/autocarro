<div class="row">
    <div class="col-lg-12">
        <div class="mb-3">
            <label">Selecione a categoria</label>
                
                <select class="form-select" name="categoria_id" onchange="updateHiddenField(this)">
                    <option value="">Selecione a categoria</option>
                    @foreach ($cats as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nome_doc }}</option>
                    @endforeach
                  </select>
                  <input type="hidden" name="nome_cat" id="nome_cat_input">
                
        </div>
        <div class="mb-3">
            <label">Nome da subcategoria</label>
                <input type="text" name="nome_subcat" class="form-control">
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
<script>
    function updateHiddenField(selectElement) {
      var selectedOption = selectElement.options[selectElement.selectedIndex];
      var nomeCat = selectedOption.text;
      document.getElementById('nome_cat_input').value = nomeCat;
    }
  </script>

