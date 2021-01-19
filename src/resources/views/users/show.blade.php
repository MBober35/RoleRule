@extends(config("role-rule.adminLayout"))

@section("meta-title", "Пользователи")

@section("header-title", "Пользователи: {$user->name}")

@section("content")
    @include("mbober-admin::users.includes.pills")

    <div class="row mb-3">
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Данные</h5>
                    <div class="row">
                        <dt class="col-sm-3">Имя</dt>
                        <dd class="col-sm-9">{{ $user->name }}</dd>

                        <dt class="col-sm-3">E-mail</dt>
                        <dd class="col-sm-9"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->roles->count())
            <div class="col-12 col-md-6 col-lg-4 mb-3">
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

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Авторизация</h5>
                    <h6 class="card-subtitle mb-3 text-muted">Генерация одноразовой ссылки</h6>

                    <div class="btn-group-vertical w-100" role="group">
                        <button type="button"
                                data-confirm="get-link-form"
                                class="btn btn-outline-secondary">
                            Вывести
                        </button>
                        <button type="submit"
                                data-confirm="self-link-form"
                                class="btn btn-outline-secondary">
                            Отправить себе
                        </button>
                        <button type="submit"
                                data-confirm="send-link-form"
                                class="btn btn-outline-secondary">
                            Отправить пользователю
                        </button>
                    </div>

                    <confirm-form id="get-link-form" confirm-text="Да, отправить!">
                        <template>
                            <form action="{{ route("admin.users.get-link", compact("user")) }}"
                                  id="get-link-form"
                                  method="post">
                                @csrf
                            </form>
                        </template>
                    </confirm-form>

                    <confirm-form id="self-link-form" confirm-text="Да, отправить!">
                        <template>
                            <form action="{{ route("admin.users.self-link", compact("user")) }}"
                                  id="self-link-form"
                                  method="post">
                                @csrf
                            </form>
                        </template>
                    </confirm-form>

                    <confirm-form id="send-link-form" confirm-text="Да, отправить!">
                        <template>
                            <form action="{{ route("admin.users.send-link", compact("user")) }}"
                                  id="send-link-form"
                                  method="post">
                                @csrf
                            </form>
                        </template>
                    </confirm-form>
                </div>
            </div>
        </div>
    </div>
@endsection