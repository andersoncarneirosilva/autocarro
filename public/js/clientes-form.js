$(document).ready(function () {
    // Inicializa o Bloodhound para buscar os clientes
    var clientes = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nome'), // Define o campo usado para busca
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: '/api/clientes?query=%QUERY', // Endpoint para buscar clientes
            wildcard: '%QUERY' // Substitui "%QUERY" pela entrada do usuário
        }
    });

    // Inicializa o Typeahead para o campo de busca
    $('#cliente-search').typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1 // Mínimo de caracteres para iniciar a busca
        },
        {
            name: 'clientes',
            display: 'nome', // Exibe o nome do cliente
            source: clientes,
            templates: {
                empty: [
                    '<div class="typeahead-empty-message">',
                    'Nenhum cliente encontrado.',
                    '</div>'
                ].join('\n'),
                suggestion: function (data) {
                    return '<div>' + data.nome + ' - ' + data.email + '</div>';
                }
            }
        }
    );
});
