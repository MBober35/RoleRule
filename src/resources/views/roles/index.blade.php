@extends(config("role-rule.adminLayout"))

@section("meta-title", "Роли")

@section("header-title", "Роли")

@section("content")
    @include("mbober-admin::roles.includes.pills")
@endsection