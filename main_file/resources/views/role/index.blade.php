@extends('layouts.admin')
@section('page-title')
{{ __('Role') }}
@endsection
@push('css-page')
@endpush
@push('script-page')
    <script>
    </script>
@endpush
@section('breadcrumb')
<h6 class="h2 d-inline-block mb-0">{{ __('Role') }}</h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Roles') }}</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0">{{ __('Manage Role') }}</h2>
                        </div>
                        @if(\Auth::user()->type=='company')
                            <div class="col-auto">
                                <span class="create-btn">
                                    <a href="#" data-url="{{ route('role.create') }}"
                                        data-ajax-popup="true"
                                        data-title="{{ __('Create New Role') }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-plus"></i> {{ __('Create') }}
                                    </a>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th>{{ __('Name') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td></td>
                                            <td>{{ $role->name }}</td>
                                            <td class="table-actions text-right">
                                                    <a href="#!"
                                                        data-url="{{ route('role.edit',$role->id) }}"
                                                        class="table-action" data-toggle="tooltip"
                                                        data-original-title="{{ __('Edit') }}"
                                                        data-ajax-popup="true"
                                                        data-title="{{ __('Edit Role') }}">
                                                        <i class="far fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('role.permission',$role->id) }}" class="table-action">
                                                        <i class="ni ni-settings-gear-65"></i>
                                                    </a>
                                                    
                                                    <a href="#!" class="table-action table-action-delete"
                                                        data-toggle="tooltip"
                                                        data-original-title="{{ __('Delete') }}"
                                                        data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                        data-confirm-yes="document.getElementById('role-delete-form-{{ $role->id }}').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['role.destroy',
                                                    $role->id],'id'=>'role-delete-form-'.$role->id]) !!}
                                                    {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
