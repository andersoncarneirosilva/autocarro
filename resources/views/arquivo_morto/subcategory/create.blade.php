<form action="{{ route('subcategory.store') }}" method="POST">
    @csrf
    @include('subcategory._partials.form-cad-subcat')
</form>
