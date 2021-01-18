@extends(config("role-rule.adminLayout"))

@section("meta-title", "Роли")

@section("header-title", "Роли: {$role->title}")

@section("content")
    @include("mbober-admin::roles.includes.pills")

    <div class="row">
        <div class="col-lg-3 col-12 mb-3">
            @include("mbober-admin::roles.includes.nav")
        </div>

        <div class="col-lg-9 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    @if (! empty($rule))
                        <form action="{{ route("admin.roles.rule", compact("role", "rule")) }}" method="post">
                            @csrf
                            @method("put")

                            <div class="mb-3">
                                <label>Доступы</label>
                                @foreach($rule->permit_list as $num => $title)
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               {{ ($rights & $num) || in_array($num, old("permisssions[]", [])) ? "checked" : "" }}
                                               value="{{ $num }}"
                                               id="check-{{ $num }}"
                                               name="permisssions[]">
                                        <label class="form-check-label" for="check-{{ $num }}">
                                            {{ $title }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3"
                                 role="group">
                                <button type="submit" class="btn btn-success mb-2">Обновить</button>
                                <button type="submit" form="default-rules" class="btn btn-warning mb-2">Стандартный доступ</button>
                                <button type="submit" form="clear-rules" class="btn btn-danger mb-2">Очистить</button>
                            </div>
                        </form>

                        <form id="default-rules" action="{{ route("admin.roles.rule", compact("role", "rule")) }}" method="post">
                            @csrf
                            @method("put")
                            <input type="hidden" name="permisssions[]" value="{{ $rule->default_rules }}">
                        </form>

                        <form id="clear-rules" action="{{ route("admin.roles.rule", compact("role", "rule")) }}" method="post">
                            @csrf
                            @method("put")
                            <input type="hidden" name="permisssions[]" value="0">
                        </form>
                    @else
                        <p>Нет правил</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection