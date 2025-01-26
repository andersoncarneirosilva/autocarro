@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

<form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" id="idFormEmployees">
    @csrf
    @include('employees._partials.form-cad-employees')
</form>

<script>
    document.getElementById('submitFormEmployess').addEventListener('click', function () {
        // Obtenha os dados do formulário
        const formData = new FormData(document.getElementById('idFormEmployees'));

        // Realize a chamada AJAX
        fetch('{{ route('employees.store') }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Verifique a resposta do servidor
            
            if (data.error) {
                // Caso haja erro, exiba o SweetAlert de erro
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: data.error
                });
            } else if (data.success) {
                // Caso contrário, redirecione para a página 'users.index'
                window.location.href = '{{ route('employees.index') }}';
            }
        })
        .catch(error => {
            console.error('Erro na requisição AJAX:', error);
            // Exiba um SweetAlert de erro genérico, se desejar
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Ocorreu um erro ao processar a requisição.'
            });
        });
    });
</script>

@endsection