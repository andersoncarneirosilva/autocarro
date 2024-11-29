@extends('layouts.app')

@section('title', 'Emprestimos')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('emprestimos.index') }}">Emprestimos</a></li>
                        <li class="breadcrumb-item active">Parcelas</li>
                    </ol>
                </div>
                <h3 class="page-title">Parcelas</h3>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Parcela</th>
                                <th>Valor da parcela</th>
                                <th>Data de vencimento</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $conta = 1;
                            @endphp
                            @foreach ($data as $dat)
                                <tr>
                                    <td>{{ $conta }}</td>
                                    <td>R${{ $dat->parcela }}</td>
                                    <td>{{ Carbon\Carbon::parse($dat->vencimento_at)->format('d/m/Y') }}</td>
                                    <td><span class="{{ $dat->class_status }}">{{ $dat->status }}</span></td>
                                    <td class="table-action" style="display: flex;">
                                        <form id="confirmForm{{ $dat->id }}"
                                            action="{{ route('parcelas.update', $dat->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" class="form-control" name="class_status"
                                                value="badge badge-success-lighten">
                                            <input type="hidden" class="form-control" name="status" value="PAGO">
                                            @if ($dat->status == 'PENDENTE')
                                                <button class="action-icon confirmBtn" data-parcela="{{ $conta }}"
                                                    title="Confirmar pagamento"
                                                    style="text-decoration: none; border: none; background-color: transparent;">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            @elseif($dat->status == 'ATRASADO')
                                                <button class="action-icon confirmBtn" data-parcela="{{ $conta }}"
                                                    title="Confirmar pagamento"
                                                    style="text-decoration: none; border: none; background-color: transparent;">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            @else
                                                <button class="action-icon" disabled
                                                    style="text-decoration: none; border: none; background-color: transparent;">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            @endif
                                        </form>
                                        @if ($dat->status == 'PENDENTE')
                                            <a href="{{ route('parcelas.destroy', $dat->id) }}"
                                                class="action-icon mdi mdi-delete" data-confirm-delete="false"></a>
                                        @else
                                            <i class="action-icon mdi mdi-delete"></i>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $conta++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
            // Captura o evento de clique nos botões de confirmação de pagamento
            const confirmButtons = document.querySelectorAll('.confirmBtn');
            confirmButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Impede o envio do formulário
        
                    const parcela = button.getAttribute('data-parcela');
        
                    // Exibe o Sweet Alert para confirmar o pagamento
                    Swal.fire({
                        title: 'Confirmar pagamento',
                        text: `Deseja realmente confirmar o pagamento da parcela ${parcela}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Se o usuário confirmar, envia o formulário
                            const formId = button.parentNode.getAttribute('id');
                            document.getElementById(formId).submit();
                        }
                    });
                });
            });
        
        </script> --}}
@endsection
