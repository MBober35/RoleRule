@extends(config("role-rule.adminLayout"))

@section("meta-title", "Роли")

@section("header-title", "Роли: {$role->title}")

@section("content")
    @include("mbober-admin::roles.includes.pills")

    <div class="row">
        <div class="col-md-3 col-12">
            @include("mbober-admin::roles.includes.nav")
        </div>

        <div class="col-md-9 col-12">
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
                                               {{ (! count($errors->all()) && in_array($num, [])) || in_array($num, old("permisssions[]", [])) ? "checked" : "" }}
                                               value="{{ $num }}"
                                               id="check-{{ $num }}"
                                               name="permisssions[]">
                                        <label class="form-check-label" for="check-{{ $num }}">
                                            {{ $title }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    @else
                        <p>Нет правил</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection