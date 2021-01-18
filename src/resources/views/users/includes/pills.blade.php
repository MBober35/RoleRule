<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills">
                    @can("viewAny", \App\Models\User::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.users.index") }}"
                               class="nav-link{{ active_state()->sliceActive("index") }}">
                                Список
                            </a>
                        </li>
                    @endcan

                    @can("create", \App\Models\User::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.users.create") }}"
                               class="nav-link{{ active_state()->sliceActive("create") }}">
                                Добавить
                            </a>
                        </li>
                    @endcan

                    @isset($user)
                        @can("view", $user)
                            <li class="nav-item">
                                <a href="{{ route("admin.users.show", compact("user")) }}"
                                   class="nav-link{{ active_state()->sliceActive("show") }}">
                                    Просмотр
                                </a>
                            </li>
                        @endcan

                        @can("update", $user)
                            <li class="nav-item">
                                <a href="{{ route("admin.users.edit", compact("user")) }}"
                                   class="nav-link{{ active_state()->sliceActive("edit") }}">
                                    Редактировать
                                </a>
                            </li>
                        @endcan

                        @can("destroy", $user)
                            <li class="nav-item">
                                <button type="button" class="btn btn-link nav-link" data-confirm="{{ "delete-form-role-{$user->id}" }}">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                                <confirm-form :id="'{{ "delete-form-role-{$user->id}" }}'">
                                    <template>
                                        <form action="{{ route('admin.users.destroy', compact("user")) }}"
                                              id="delete-form-role-{{ $user->id }}"
                                              class="btn-group"
                                              method="post">
                                            @csrf
                                            @method("delete")
                                        </form>
                                    </template>
                                </confirm-form>
                            </li>
                        @endcan
                    @endisset
                </ul>
            </div>
        </div>
    </div>
</div>