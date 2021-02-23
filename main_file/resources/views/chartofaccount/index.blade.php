@extends('layouts.admin')
@section('page-title')
{{__('Contract')}}
@endsection
@push('css-page')
@endpush
@push('script-page')
@endpush
@section('breadcrumb')
<h6 class="h2 d-inline-block mb-0">{{__('Chart of accounts')}}</h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Chart of accounts')}}</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0">{{__('Manage Chat of accounts')}}</h2>
                        </div>
                        @if(\Auth::user()->type=='company')
                        <div class="col-auto">
                            <span class="create-btn">
                                <a href="#" data-url="{{ route('chartofaccount.create') }}" data-ajax-popup="true" data-title="{{__('Create New Chat of account')}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> {{__('Create')}}
                                </a>
                            </span>
                            <span class="create-btn">
                                <a href="#" data-url="{{ route('chartofaccountgroup.create') }}" data-ajax-popup="true" data-title="{{__('Create New Chat of account')}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> {{__('Add Group')}}
                                </a>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Group')}}</th>
                                @if(\Auth::user()->type=='company')
                                <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($chartofaccounts as $chart) {
                            ?>
                                <tr>
                                    <td><?= $chart['name'] ?></td>
                                    <td><?= (new \App\Http\Controllers\ChartOfAccount())->getGroupName($chart['group_id']) ?></td>
                                    @if(\Auth::user()->type=='company')
                                    <td class="action text-right">
                                        <a class="table-action" data-ajax-popup="true" data-title="Edit <?= $chart['name'] ?>" data-original-title="Edit" data-url="http://dekomdmc.mitaapps.com/chartofaccount/<?= $chart['id'] ?>/edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a class="table-action table-action-delete" data-original-title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="window.location.href = '/chartofaccount/delete/<?=$chart['id']?>'" >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection