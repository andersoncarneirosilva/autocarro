<form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('documentos._partials.form-cad-doc')
</form>

