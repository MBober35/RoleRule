<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}"
                           class="nav-link{{ active_state()->sliceActive("index") }}">
                            Список
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.users.create") }}"
                           class="nav-link{{ active_state()->sliceActive("create") }}">
                            Добавить
                        </a>
                    </li>

                    @isset($user)
                        <li class="nav-item">
                            <a href="{{ route("admin.users.show", compact("role")) }}"
                               class="nav-link{{ active_state()->sliceActive("show") }}">
                                Просмотр
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route("admin.users.edit", compact("role")) }}"
                               class="nav-link{{ active_state()->sliceActive("edit") }}">
                                Редактировать
                            </a>
                        </li>

                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link" data-confirm="{{ "delete-form-role-{$role->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-role-{$role->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.users.destroy', compact("role")) }}"
                                          id="delete-form-role-{{ $role->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("delete")
                                    </form>
                                </template>
                            </confirm-form>
                        </li>
                    @endisset
                </ul>
            </div>
        </div>
    </div>
</div>