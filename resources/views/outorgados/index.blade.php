@extends('layouts.app')

@section('title', 'Outorgados')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Outorgados</li>
                </ol>
            </div>
            <h3 class="page-title">Outorgados</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Outorgados cadastrados</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalCadastroOut">Cadastrar</button> 
                    </div>
                </div>
                @if ($outs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Email</th>
                                
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($outs as $out)
                                <tr>
                                    <td>{{ $out->nome_outorgado }}</td>
                                    <td>{{ $out->cpf_outorgado }}</td>
                                    <td>{{ $out->email_outorgado }}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-id="{{ $out->id }}" onclick="openEditModalOutorgado(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>
                                        </a>
                                        <a href="{{ route('outorgados.destroy', $out->id) }}"
                                            class="action-icon mdi mdi-delete" data-confirm-delete="true"></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($outs->total() == 0)
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        {{ $outs->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div>
</div>


<div class="modal fade" id="modalCadastroOut" tabindex="-1" aria-labelledby="modalCadastroOutLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCadastroOutLabel">Cadastrar Outorgado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('outorgados.store') }}" method="POST" id="form-cad" enctype="multipart/form-data"  class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome_outorgado" name="nome_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf_outorgado" name="cpf_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="end_outorgado" name="end_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email_outorgado" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Seleciona todos os campos de entrada no formulário
                        const campos = document.querySelectorAll('#nome_outorgado, #cpf_outorgado, #end_outorgado');
                
                        // Adiciona um ouvinte de evento em cada campo
                        campos.forEach(campo => {
                            campo.addEventListener('input', (event) => {
                                // Força o valor para maiúsculas
                                event.target.value = event.target.value.toUpperCase();
                            });
                        });
                    });
                </script>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInfoModalLabel">Editar Informações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @foreach ($outs as $out)
            <form action="{{ route('outorgados.update', $out->id) }}" id="edit-form-cad" method="POST">
                @csrf
                @method('PUT') <!-- Usado para edições -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome_outorgado" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="edit_nome_outorgado" name="nome_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf_outorgado" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="edit_cpf_outorgado" name="cpf_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_outorgado" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="edit_end_outorgado" name="end_outorgado" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" id="edit_email_outorgado" name="email_outorgado" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
            @endforeach
        </div>
    </div>
</div>

<script>
    function openEditModalOutorgado(event) {
    event.preventDefault();

    // Obtenha o ID do documento
    //const docId = event.currentTarget.getAttribute('data-id');
    const docId = event.target.closest('a').getAttribute('data-id');
    // Faça uma requisição AJAX para buscar os dados
    console.log(docId);
    $.ajax({
        url: `/outorgados/${docId}`,
        method: 'GET',
        success: function(response) {
            //console.log(response);
            // Preencha os campos do modal com os dados do documento
            $('#edit_nome_outorgado').val(response.nome_outorgado);
            $('#edit_cpf_outorgado').val(response.cpf_outorgado);
            $('#edit_end_outorgado').val(response.end_outorgado);
            $('#edit_email_outorgado').val(response.email_outorgado);

            // Atualize a ação do formulário para apontar para a rota de edição
            $('#editForm').attr('action', `/outorgados/${docId}`);

            // Exiba o modal
            $('#editInfoModal').modal('show');
        },
        error: function() {
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível carregar os dados.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cpf_outorgado').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('edit_cpf_outorgado').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });
</script>

<script>
    // Função para validar CPF
    function validarCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/[^\d]+/g, '');

        // Verifica se o CPF tem 11 dígitos ou é uma sequência repetida
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        // Função para calcular os dígitos verificadores
        function calcularDigito(base) {
            let soma = 0;
            for (let i = 0; i < base.length; i++) {
                soma += base[i] * (base.length + 1 - i);
            }
            const resto = soma % 11;
            return resto < 2 ? 0 : 11 - resto;
        }

        // Calcula o primeiro dígito verificador
        const primeiroDigito = calcularDigito(cpf.slice(0, 9));

        // Verifica o primeiro dígito
        if (primeiroDigito !== parseInt(cpf[9], 10)) {
            return false;
        }

        // Calcula o segundo dígito verificador
        const segundoDigito = calcularDigito(cpf.slice(0, 10));

        // Verifica o segundo dígito
        return segundoDigito === parseInt(cpf[10], 10);
    }

    // Adiciona evento no envio do formulário
    document.getElementById('form-cad').addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio do formulário para verificar antes
        const cpfInput = document.getElementById('cpf_outorgado');

        if (validarCPF(cpfInput.value)) {
            // CPF válido, aqui você pode prosseguir com o envio do formulário
            //alert('CPF válido!');
             e.target.submit(); // Envia o formulário caso o CPF seja válido
        } else {
            // Exibe o SweetAlert com erro por 5 segundos
            Swal.fire({
                icon: 'error',
                title: 'CPF Inválido!',
                text: 'O CPF informado não é válido.',
                timer: 5000, // Exibe por 5 segundos
                showConfirmButton: true, // Remove o botão de confirmação
                timerProgressBar: true,
            });
        }
    });
</script>

<script>
    // Função para validar CPF
    function validarCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/[^\d]+/g, '');

        // Verifica se o CPF tem 11 dígitos ou é uma sequência repetida
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        // Função para calcular os dígitos verificadores
        function calcularDigito(base) {
            let soma = 0;
            for (let i = 0; i < base.length; i++) {
                soma += base[i] * (base.length + 1 - i);
            }
            const resto = soma % 11;
            return resto < 2 ? 0 : 11 - resto;
        }

        // Calcula o primeiro dígito verificador
        const primeiroDigito = calcularDigito(cpf.slice(0, 9));

        // Verifica o primeiro dígito
        if (primeiroDigito !== parseInt(cpf[9], 10)) {
            return false;
        }

        // Calcula o segundo dígito verificador
        const segundoDigito = calcularDigito(cpf.slice(0, 10));

        // Verifica o segundo dígito
        return segundoDigito === parseInt(cpf[10], 10);
    }

    // Adiciona evento no envio do formulário
    document.getElementById('edit-form-cad').addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio do formulário para verificar antes
        const cpfInput = document.getElementById('edit_cpf_outorgado');

        if (validarCPF(cpfInput.value)) {
            // CPF válido, aqui você pode prosseguir com o envio do formulário
            //alert('CPF válido!');
             e.target.submit(); // Envia o formulário caso o CPF seja válido
        } else {
            // Exibe o SweetAlert com erro por 5 segundos
            Swal.fire({
                icon: 'error',
                title: 'CPF Inválido!',
                text: 'O CPF informado não é válido.',
                timer: 5000, // Exibe por 5 segundos
                showConfirmButton: true, // Remove o botão de confirmação
                timerProgressBar: true,
            });
        }
    });
</script>

    @endsection
