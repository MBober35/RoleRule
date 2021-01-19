<div class="table-responsive">
    <table class="table table-hover">
        <caption>
            Всего: {{ $users->total() }}
        </caption>
        <thead>
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>E-mail</th>
            <th>Роли</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $item)
            <tr>
                <td>
                    {{ active_state()->getItemPager($users, $loop->iteration) }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                </td>
                <td>
                    <ul class="list-unstyled">
                        @foreach ($item->roles as $role)
                            <li>
                                @can("role-master")
                                    <a href="{{ route("admin.roles.show", compact("role")) }}">
                                        {{ $role->title }}
                                    </a>
                                @else
                                    {{ $role->title }}
                                @endcan
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <div role="toolbar" class="btn-toolbar">
                        <div class="btn-group mr-1">
                            @can("update", $item)
                                <a href="{{ route("admin.users.edit", ["user" => $item]) }}" class="btn btn-primary">
                                    <i class="far fa-edit"></i>
                                </a>
                            @endcan
                            @can("view", $item)
                                <a href="{{ route('admin.users.show', ['user' => $item]) }}" class="btn btn-dark">
                                    <i class="far fa-eye"></i>
                                </a>
                            @endcan
                            @can("delete", $item)
                                <button type="button" class="btn btn-danger" data-confirm="{{ "delete-user-form-{$item->id}" }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endcan
                        </div>
                    </div>
                    @can("delete", $item)
                        <confirm-form :id="'{{ "delete-user-form-{$item->id}" }}'">
                            <template>
                                <form action="{{ route('admin.users.destroy', ['user' => $item]) }}"
                                      id="delete-user-form-{{ $item->id }}"
                                      class="btn-group"
                                      method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            </template>
                        </confirm-form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>