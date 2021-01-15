@extends(config("role-rule.adminLayout"))

@section("meta-title", "Роли")

@section("header-title", "Роли")

@section("content")
    @include("mbober-admin::roles.includes.pills")

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Заголовок</th>
                                <th>Ключ</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>
                                        {{ active_state()->getItemPager($roles, $loop->iteration) }}
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->key }}</td>
                                    <td>
                                        <div role="toolbar" class="btn-toolbar">
                                            <div class="btn-group mr-1">
                                                <a href="{{ route("admin.roles.edit", ["role" => $item]) }}" class="btn btn-primary">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.roles.show', ['role' => $item]) }}" class="btn btn-dark">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" data-confirm="{{ "delete-role-form-{$item->id}" }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <confirm-form :id="'{{ "delete-role-form-{$item->id}" }}'">
                                            <template>
                                                <form action="{{ route('admin.roles.destroy', ['role' => $item]) }}"
                                                      id="delete-role-form-{{ $item->id }}"
                                                      class="btn-group"
                                                      method="post">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                </form>
                                            </template>
                                        </confirm-form>
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

@if ($roles->lastPage() > 1)
    @section('links')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif