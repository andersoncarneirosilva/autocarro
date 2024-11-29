<form action="{{ route('category.store') }}" method="POST">
    @csrf
    @include('category._partials.form-cad-cat')
</form>
