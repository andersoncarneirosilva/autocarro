<div class="modal fade" id="modalCadastrarMulta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-soft-danger text-danger">
                <h4 class="modal-title">Cadastrar Multa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('veiculos.gastos.store') }}" method="POST" id="formCadastrarMulta">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tipo_lancamento" value="multa">
                    <input type="hidden" name="categoria" value="Multa">
                    <input type="hidden" name="veiculo_id" value="{{ $veiculo->id }}">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
    <label class="form-label fw-bold text-danger">Cód. Infração</label>
    <input type="text" class="form-control" name="codigo_infracao" id="codigo_infracao" placeholder="Ex: 501-0">
</div>
                        <div class="col-md-6 mb-3">
    <label class="form-label fw-bold">Valor da Multa</label>
    <input type="text" class="form-control money" name="valor" id="valor_multa" required>
</div>
                    </div>
                    <div class="mb-3">
    <label class="form-label fw-bold">Descrição da Infração</label>
    <textarea class="form-control" name="descricao" id="descricao_multa" rows="2" placeholder="Ex: Avançar sinal vermelho"></textarea>
</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger w-100">Registrar Multa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#formCadastrarMulta').on('submit', function() {
            let btn = $('#btnSalvarGasto');
            btn.prop('disabled', true);
            btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Salvando...');
        });
    });

    $(document).ready(function() {
    $('.money').on('keyup', function() {
        let valor = $(this).val().replace(/\D/g, '');
        valor = (valor / 100).toFixed(2) + '';
        valor = valor.replace(".", ",");
        valor = valor.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
        valor = valor.replace(/(\d)(\d{3}),/g, "$1.$2,");
        
        $(this).val(valor !== 'NaN' && valor !== '0,00' ? valor : '');
    });
});
</script>
<script>
$(document).ready(function() {
    
    $('#codigo_infracao').on('blur', function() {
        let codigo = $(this).val().trim();
        
        if (codigo.length >= 4) {
            $.ajax({
                // Adicionamos a barra no início para ser absoluta
                url: '/consultar-infracao/' + codigo, 
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('Dados recebidos:', data);
                    if (data) {
                        $('#descricao_multa').val(data.descricao);
                        
                        // Formatação garantida para a sua máscara .money
                        let valorDecimal = parseFloat(data.valor);
                        let valorString = valorDecimal.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                        
                        $('#valor_multa').val(valorString).trigger('keyup');
                        $('#codigo_infracao').addClass('is-valid').removeClass('is-invalid');
                    }
                },
                error: function(xhr) {
                    console.error('Erro na requisição:', xhr.status);
                    $('#codigo_infracao').addClass('is-invalid').removeClass('is-valid');
                }
            });
        }
    });
});
</script>