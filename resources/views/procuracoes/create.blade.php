<form action="{{ route('procuracoes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('procuracoes._partials.form-proc')
</form>

