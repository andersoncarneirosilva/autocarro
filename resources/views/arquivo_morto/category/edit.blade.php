<form action="{{ route('category.update', $cats->id) }}" method="POST">
    @csrf
    @method('PUT')
    {{-- @include('users._partials.form-edit-user') --}}
    @include('category._partials.form-edit-cat')
</form>
