@extends(config("role-rule.adminLayout"))

@section("meta-title", "Пользователи")

@section("header-title", "Пользователи")

@section("content")
    @include("mbober-admin::users.includes.pills")

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
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
                                                    <a href="{{ route("admin.roles.show", compact("role")) }}">
                                                        {{ $role->title }}
                                                    </a>
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
                                                @can("destroy", $item)
                                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-user-form-{$item->id}" }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>
                                        @can("destroy", $item)
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
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($users->lastPage() > 1)
    @section("links")
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif