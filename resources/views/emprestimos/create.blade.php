
<form action="{{ route('emprestimos.store') }}" method="POST">
    @csrf
    @include('emprestimos._partials.form-cad-emprestimo')
</form>

