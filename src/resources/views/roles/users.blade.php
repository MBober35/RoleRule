@extends(config("role-rule.adminLayout"))

@section("meta-title", "Роли")

@section("header-title", "Роли")

@section("content")
    @include("mbober-admin::roles.includes.pills")

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @include("mbober-admin::roles.includes.user-search")
                </div>
                <div class="card-body">
                    @include("mbober-admin::users.includes.index-table")
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($users->lastPage() > 1)
    @section('links')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif