<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                
                <table class="table table-striped table-centered mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($users as $user)
                        <tr data-user-id="{{ $user->id }}">
                            <td class="table-user">
                                @if($user->image)
                                    <img src="{{ url("storage/{$user->image}") }}" class="me-2 rounded-circle">
                                @else
                                <img src="{{ url("assets/img/icon_user.png") }}" class="me-2 rounded-circle">
                                @endif
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->telefone }}</td>
                            <td>{{ $user->perfil }}</td>
                            <td class="table-action">

                                <a href="{{ route('users.edit', $user->id) }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-target="#standard-modal-edit"
                                    class="font-18 text-info me-2"
                                    data-bs-placement="top"
                                    aria-label="Edit"
                                    data-bs-original-title="Editar"><i class="uil uil-pen"></i></a>
                                <a href="{{ route('users.destroy', $user->id) }}"
                                    class="mdi mdi-delete font-18 text-danger" 
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    aria-label="Delete"
                                    data-bs-original-title="Excluír" data-confirm-delete="true"></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    {{ $users->appends([
        'search' => request()->get('search', '')
    ])->links('components.pagination') }}
</div>