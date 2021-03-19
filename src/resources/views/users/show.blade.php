@extends("layouts.admin")

@section("meta-title", "Пользователи")

@section("header-title", "Пользователи: {$user->name}")

@section("content")
    @include("mbober-admin::users.includes.pills")

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mb-3">
        @include("mbober-admin::users.includes.data")
        @include("mbober-admin::users.includes.roles")
        @include("mbober-admin::users.includes.auth")
    </div>
@endsection