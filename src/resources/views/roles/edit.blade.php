@extends(config("role-rule.adminLayout"))

@section("meta-title", "Роли")

@section("header-title", "Роли: {$role->title}")

@section("content")
    @include("mbober-admin::roles.includes.pills")

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("admin.roles.update", compact("role")) }}" method="post">
                        @csrf
                        @method("put")

                        <div class="mb-3">
                            <label for="title" class="form-label">Заголовок <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   required
                                   value="{{ old("title", $role->title) }}"
                                   class="form-control @error("title") is-invalid @enderror">
                            @error("title")
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="key" class="form-label">Адрес</label>
                            <input type="text"
                                   id="key"
                                   {{ $role->default ? "readonly" : "" }}
                                   name="key"
                                   value="{{ old("key", $role->key) }}"
                                   class="form-control @error("key") is-invalid @enderror">
                            @error("key")
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
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