@extends('layouts.app')

@section('title', 'Outorgados')

@section('content')

@include('outorgados._partials.cadastrar-outorgado')

@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

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
                                    @php
                                        $email = $out->email_outorgado;
                                        $emailParts = explode('@', $email);
                                        $emailMasked = substr($emailParts[0], 0, 2) . str_repeat('*', strlen($emailParts[0]) - 2) . '@' . $emailParts[1];
                                    @endphp

                                    <td>{{ $emailMasked }}</td>
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
            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro no cadastro!',
                        html: '{!! implode("<br>", $errors->all()) !!}',
                    });
                </script>
            @endif

        </div>
    </div>
    <div class="row">
        {{ $outs->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div>
</div>



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

{{-- <script>
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
</script> --}}

{{-- <script>
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

</script> --}}

    @endsection
