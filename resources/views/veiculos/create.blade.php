<form action="{{ route('veiculos.store') }}" method="POST" enctype="multipart/form-data" id="formDoc">
    @csrf
    @include('veiculos._partials.form-cad-veiculo')
</form>
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("formDoc"); // Seleciona o formulário corretamente
        const submitButton = document.getElementById("submitButton"); // Botão original
        const loadingButton = document.getElementById("loadingButton"); // Botão com spinner
        const arquivoInput = document.getElementById("arquivo_doc"); // Campo de upload de arquivo
    
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Evita o envio do formulário automaticamente
    
            // Obtém o arquivo selecionado
            const arquivo = arquivoInput.files[0];
    
            // Valida se um arquivo foi selecionado
            if (!arquivo) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Por favor, selecione um arquivo em PDF.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
    
            // Valida se o arquivo é do tipo PDF
            if (arquivo.type !== "application/pdf") {
                Swal.fire({
                    title: 'Erro!',
                    text: 'O arquivo selecionado deve ser um PDF.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
    
            // Se tudo estiver certo, exibe o spinner e esconde o botão original
            submitButton.style.display = "none";
            loadingButton.style.display = "inline-block";
    
            // Aguarde um pequeno tempo para visualização e envie o formulário
            setTimeout(() => {
                form.submit();
            }, 500); // Pequeno delay para o usuário perceber o spinner
        });
    });
    </script> --}}