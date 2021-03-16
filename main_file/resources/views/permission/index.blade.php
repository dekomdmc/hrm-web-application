@extends('layouts.admin')
@section('page-title')
{{ __('Permission') }}
@endsection
@push('css-page')
@endpush
@push('script-page')
    <script>
    </script>
@endpush
@section('breadcrumb')
<h6 class="h2 d-inline-block mb-0">{{ __('Permission') }}</h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Permissions') }}</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs p-3">
                <li class="active">
                    <a data-toggle="tab" href="#view-permissions">View Permissions</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#create-permissions">Create Permissions</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#edit-permissions">Edit Permissions</a>
                </li>
            </ul>
        </div>
        <div class="col-lg-12">
            {{ Form::open(array('url'=> route('permission.add', $user->id),'method'=>'post')) }}

            <div class="tab-content" id="nav-tabContent">
                <div class="card">
                    <div class="card-header">
                        {{ $user->name }} Permissions
                        <div class="float-right">
                            <a href="#" data-url="{{ route('permission.create') }}"
                                data-ajax-popup="true"
                                data-title="{{ __('Create New Permission') }}"
                                class="btn btn-primary btn-sm">Add Permission</a>
                            <input class="btn btn-sm btn-primary" type="submit" value="Save">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="view-permissions" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="datatable-basic">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>View Permission</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                            @if($permission->type == 'view')
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input
                                                                <?= $user->hasPermissionTo($permission->name) ? 'checked' : '' ?>
                                                                id="{{ $permission->id }}" name="permissions[]"
                                                                value="{{ $permission->id }}" class="form-check-input"
                                                                type="checkbox">
                                                            <label class="form-check-label"
                                                                for="{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="create-permissions" role="tabpanel"
                            aria-labelledby="create-permissions-tab">
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="datatable-basic">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Permissions</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                            @if($permission->type == 'create')
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input
                                                                <?= $user->hasPermissionTo($permission->name) ? 'checked' : '' ?>
                                                                id="{{ $permission->id }}" name="permissions[]"
                                                                value="{{ $permission->id }}" class="form-check-input"
                                                                type="checkbox">
                                                            <label class="form-check-label"
                                                                for="{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="edit-permissions" role="tabpanel"
                            aria-labelledby="create-permissions-tab">...</div>
                    </div>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
