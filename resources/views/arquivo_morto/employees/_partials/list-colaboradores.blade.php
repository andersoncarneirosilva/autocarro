<div class="row">
    <div class="col-sm-12">

        @if ($employees->total() != 0)

        <table class="table table-centered mb-0 table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Perfil</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach ($employees as $employee)
                <tr data-user-id="{{ $employee->id }}">
                    <td class="table-user">
                        @if($employee->image)
                            <img src="{{ url("storage/{$employee->image}") }}" class="me-2 rounded-circle">
                        @else
                        <img src="{{ url("assets/img/icon_user.png") }}" class="me-2 rounded-circle">
                        @endif
                        {{ $employee->name }}
                    </td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->telefone }}</td>
                    <td>{{ $employee->perfil }}</td>
                    <td class="table-action">
                        <a href="{{ route('employees.show', $employee->id) }}" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                        <a href="{{ route('employees.destroy', $employee->id) }}" class="action-icon mdi mdi-delete delete-user"></a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @elseif($employees->total() == 0)
            <div class="alert alert-warning" role="alert">
                NENHUM RESULTADO ENCONTRADO!
            </div>
        @endif
    </div>
</div>
<br>
<div class="row">
    {{ $employees->appends([
        'search' => request()->get('search', '')
    ])->links('components.pagination') }}
</div>