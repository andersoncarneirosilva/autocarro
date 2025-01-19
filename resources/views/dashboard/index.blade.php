@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
            <h3 class="page-title">Dashboard</h3>
        </div>
    </div>
</div>
<br>
        <!-- Para Mobile -->
        <div class="card ribbon-box d-block d-md-none">
          <div class="card-body">
              <div class="ribbon ribbon-success float-end"><i class="mdi mdi-access-point me-1"></i> 19.01.2025</div>
              <h5 class="text-success float-start mt-0">Novidades no App!</h5>
              <div class="ribbon-content">
                  <ul>
                    <li>Agora cada usuário tem um espaço limitado para armazenamento de arquivos.</li>
                    <li>Correção no campo de busca para smartphone.</li>
                    <li>Campo CRV não será exibido para editar caso o documento seja digital.</li>
                    <li>Página modelo de procuração reformulada</li>
                  </ul>
              </div>
          </div> <!-- end card-body -->
      </div> <!-- end card-->
@can('access-lojista')
@include('dashboard.widgets.widgets')
@include('dashboard.widgets.content')
{{-- @include('dashboard.widgets.formularios') --}}
@endcan


@can('access-despachante')
@include('dashboard.widgets.widgets')
@include('dashboard.widgets.content')
@endcan


<script>

function openInfoModal(event) {
    event.preventDefault(); // Impede o comportamento padrão do link

    // Obtém o ID do documento do atributo 'data-id'
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    //const url = `/documentos/gerarProc/${docId}/${encodeURIComponent(address)}`;
    //console.log("ID do Documento:", docId);  // Verifique se o ID está correto no console
    //console.log("ID do Documento:", docId);

    // Faz uma requisição AJAX para buscar as informações do documento
    $.ajax({
        url: `/documentos/${docId}`, // Substitua com a URL para pegar as informações do documento
        method: 'GET',
        success: function(response) {
            //console.log("Resposta do Servidor:", response);

            //console.log(response); // Verifique o que está retornando na resposta
            // Preenche o modal com as informações
            $('#marca').text(response.marca);
            $('#placa').text(response.placa);
            $('#chassi').text(response.chassi);
            $('#cor').text(response.cor);
            $('#ano').text(response.ano);
            $('#renavam').text(response.renavam);
            $('#nome').text(response.nome);
            $('#cpf').text(response.cpf);
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
      var chartsPie = document.querySelectorAll(".chart-pie");
    
      chartsPie.forEach(function(chart) {
        if (!chart.getAttribute('data-chart-initialized')) {
            new Chart(chart, {
            type: "pie",
              data: {
                labels: ["Chrome", "Firefox", "IE"],
                datasets: [{
                  data: [4306, 3801, 1689],
                  backgroundColor: [
                    window.theme?.primary || "#007bff",
                    window.theme?.warning || "#ffc107",
                    window.theme?.danger || "#dc3545"
                  ],
                  borderWidth: 5
                }]
              },
              options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                plugins: {
                  legend: {
                    display: false
                  }
                }
              }
            });
            chart.setAttribute("data-chart-initialized", "true");
        }
      });
    });
    </script>
@endsection