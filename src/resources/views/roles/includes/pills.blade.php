<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}"
                           class="nav-link{{ active_state()->sliceActive("index") }}">
                            Список
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.roles.create") }}"
                           class="nav-link{{ active_state()->sliceActive("create") }}">
                            Добавить
                        </a>
                    </li>

                    @isset($role)
                        <li class="nav-item">
                            <a href="{{ route("admin.roles.show", compact("role")) }}"
                               class="nav-link{{ active_state()->sliceActive("show") }}">
                                Просмотр
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route("admin.roles.edit", compact("role")) }}"
                               class="nav-link{{ active_state()->sliceActive("edit") }}">
                                Редактировать
                            </a>
                        </li>
                    @endisset
                </ul>
            </div>
        </div>
    </div>
</div>