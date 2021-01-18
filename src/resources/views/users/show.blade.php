@extends(config("role-rule.adminLayout"))

@section("meta-title", "Пользователи")

@section("header-title", "Пользователи: {$user->name}")

@section("content")
    @include("mbober-admin::users.includes.pills")

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body"></div>
            </div>
        </div>
    </div>
@endsection