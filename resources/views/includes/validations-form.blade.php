@if($errors->any())
<ul class="error">    
    @foreach ($errors->all() as $error)
        <li class="erros">{{ $error }}</li>    
    @endforeach
</ul>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif