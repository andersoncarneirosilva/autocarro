<form action="{{ route('veiculos.store') }}" method="POST" enctype="multipart/form-data" id="formDoc">
    @csrf
    @include('veiculos._partials.form-cad-proc')
</form>

<script>
    // Obtenha o formulário
    const form = document.getElementById('formDoc');
    // Obtenha os inputs do arquivo e do endereço
    const arquivoInput = document.getElementById('arquivo_doc');
    // Adicionando um evento de submit para o formulário
    form.addEventListener('submit', function(event) {
        console.lgo(event);
        // Impede o comportamento padrão do formulário
        event.preventDefault();

        // Obtém o arquivo
        const arquivo = arquivoInput.files[0]; 
        console.log(arquivo);

        // Verifica se o arquivo foi selecionado
        if (!arquivo) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, selecione um arquivo em PDF.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Impede o envio do formulário
        }

        // Verifica se o arquivo é do tipo PDF
        if (arquivo.type !== 'application/pdf') {
            Swal.fire({
                title: 'Erro!',
                text: 'O arquivo selecionado deve ser um PDF.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Impede o envio do formulário
        }

        // Se o arquivo for válido, envie o formulário
        form.submit();
    });
</script>
