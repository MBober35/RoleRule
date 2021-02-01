@extends("layouts.admin")

@section("meta-title", "Пользователи")

@section("header-title", "Пользователи")

@section("content")
    @include("mbober-admin::users.includes.pills")

    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @include("mbober-admin::users.includes.search")
                </div>
                <div class="card-body">
                    @include("mbober-admin::users.includes.index-table")
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($users->lastPage() > 1)
    @section("links")
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif