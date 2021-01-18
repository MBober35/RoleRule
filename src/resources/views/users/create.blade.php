@extends(config("role-rule.adminLayout"))

@section("meta-title", "Роли")

@section("header-title", "Пользователи: Добавить")

@section("content")
    @include("mbober-admin::users.includes.pills")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection