@extends("layouts.admin")

@section("meta-title", "Роли")

@section("header-title", "Роли: Добавить")

@section("content")
    @include("mbober-admin::roles.includes.pills")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("admin.roles.store") }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Заголовок <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   required
                                   value="{{ old('title') }}"
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
                                   name="key"
                                   value="{{ old('key') }}"
                                   class="form-control @error("key") is-invalid @enderror">
                            @error("key")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3"
                             role="group">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection