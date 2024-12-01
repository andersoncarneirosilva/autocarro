<form action="{{ route('procuracoes.store') }}" method="POST" enctype="multipart/form-data" id="formProc">
    @csrf
    @include('procuracoes._partials.form-proc')
</form>

<script>
    // Obtenha o formulário
    const form = document.getElementById('formProc');

    // Obtenha os inputs do arquivo e do endereço
    const arquivoInput = document.getElementById('arquivo_doc');
    const endInput = document.getElementById('idEndereco');
    
    // Adicionando um evento de submit para o formulário
    form.addEventListener('submit', function(event) {
        // Impede o comportamento padrão do formulário
        event.preventDefault();

        // Verifica se o endereço foi preenchido
        const endereco = endInput.value.trim();
        if (!endereco) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, preencha o endereço.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;  // Impede o envio do formulário
        }
        
        // Obtém o arquivo
        const arquivo = arquivoInput.files[0]; 

        // Verifica se o arquivo foi selecionado
        if (!arquivo) {
            Swal.fire({
                title: 'Erro!',
                text: 'Por favor, selecione um arquivo.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;  // Impede o envio do formulário
        }

        

        // Se o arquivo e o endereço estiverem presentes, envie o formulário
        form.submit();
    });
</script>

