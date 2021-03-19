@if ($user->roles->count())
    <div class="col mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Роли</h5>
                <ul class="list-unstyled">
                    @foreach ($user->roles as $role)
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
            </div>
        </div>
    </div>
@endif