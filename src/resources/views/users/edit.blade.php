@extends(config("role-rule.adminLayout"))

@section("meta-title", "Пользователи")

@section("header-title", "Пользователи: {$user->name}")

@section("content")
    @include("mbober-admin::users.includes.pills")

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("admin.users.update", compact("user")) }}" method="post">
                        @csrf
                        @method("put")

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   required
                                   value="{{ old("name", $user->name) }}"
                                   class="form-control @error("name") is-invalid @enderror">
                            @error("name")
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   required
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control @error("email") is-invalid @enderror">
                            @error("email")
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Роли</label>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           {{ (! count($errors->all()) && in_array($role->id, $current)) || in_array($role->id, old("roles[]", [])) ? "checked" : "" }}
                                           value="{{ $role->id }}"
                                           id="check-{{ $role->id }}"
                                           name="roles[]">
                                    <label class="form-check-label" for="check-{{ $role->id }}">
                                        {{ $role->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-3"
                             role="group">
                            <button type="submit" class="btn btn-success">Обновить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection