<form action="{{ route('transportadoras.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('transportadoras._partials.form-cad-trans')
</form>

