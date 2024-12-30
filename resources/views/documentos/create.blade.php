<form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data" id="formDoc">
    @csrf
    @include('documentos._partials.form-cad-doc')
</form>

<script>
    // Obtenha o formulário
    const form = document.getElementById('formDoc');

    // Obtenha os inputs do arquivo e do endereço
    const arquivoInput = document.getElementById('arquivo_doc');
    
    // Adicionando um evento de submit para o formulário
    form.addEventListener('submit', function(event) {
        // Impede o comportamento padrão do formulário
        event.preventDefault();
        
        // Obtém o arquivo
        const arquivo = arquivoInput.files[0]; 

        // Verifica se o arquivo foi selecionado
        if (!arquivo) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, selecione um arquivo em pdf.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;  // Impede o envio do formulário
        }

        

        // Se o arquivo e o endereço estiverem presentes, envie o formulário
        form.submit();
    });
</script>