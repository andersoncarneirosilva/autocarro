
<form action="{{ route('adiantamento.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('adiantamento._partials.form-cad-ad')
</form>

