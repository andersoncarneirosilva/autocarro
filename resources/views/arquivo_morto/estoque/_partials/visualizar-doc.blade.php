<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong><u>INFORMAÇÕES DO VEÍCULO</u></strong></p>
                
                <p><strong>Marca:</strong> <span id="marca"></span></p>
                <p><strong>Placa:</strong> <span id="placa"></span></p>
                
                <p><strong>Cor:</strong> <span id="cor"></span></p>
                <p><strong>Ano:</strong> <span id="ano"></span></p>
                <p><strong>Renavam:</strong> <span id="renavam"></span></p>
                <p><strong>Chassi:</strong> <span id="chassi"></span></p>
                <p><strong>Cidade:</strong> <span id="cidade"></span></p>
                <p><strong>CRV:</strong> <span id="crv"></span></p>
                <p><strong>Placa Anterior:</strong> <span id="placa_anterior"></span></p>
                <p><strong>Categoria:</strong> <span id="categoria"></span></p>
                <p><strong>Motor:</strong> <span id="motor"></span></p>
                <p><strong>Combustível:</strong> <span id="combustivel"></span></p>
                <p><strong>Observações do veículo:</strong> <span id="infos"></span></p>
                
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openInfoModal(event) {
        event.preventDefault();
        const docId = event.target.closest('a').getAttribute('data-id');
        
        $.ajax({
            url: `/estoque/${docId}`, 
            method: 'GET',
            success: function(response) {
                //console.log(response);
                $('#marca').text(response.marca);
                $('#placa').text(response.placa);
                $('#chassi').text(response.chassi);
                $('#cor').text(response.cor);
                $('#ano').text(response.ano);
                $('#renavam').text(response.renavam);
                $('#cidade').text(response.cidade);
                $('#crv').text(response.crv);
                $('#placa_anterior').text(response.placaAnterior);
                $('#categoria').text(response.categoria);
                $('#motor').text(response.motor);
                $('#combustivel').text(response.combustivel);
                $('#infos').text(response.infos);
    
                // Exibe o modal
                $('#infoModal').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Erro ao carregar as informações.');
            }
        });
    }
    </script>