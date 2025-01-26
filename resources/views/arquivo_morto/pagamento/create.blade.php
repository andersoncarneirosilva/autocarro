<form action="{{ route('pagamento.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('pagamento._partials.form-cad-pg')
</form>
