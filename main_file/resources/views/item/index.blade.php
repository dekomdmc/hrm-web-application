@extends('layouts.admin')
@section('page-title')
{{__('Items')}}
@endsection
@push('css-page')
@endpush
@push('script-page')
@endpush
@section('breadcrumb')
<h6 class="h2 d-inline-block mb-0">{{__('Items')}}</h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Item')}}</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0">{{__('Manage Items (Products)')}}</h2>
                        </div>
                        @if(\Auth::user()->type=='company' || \Auth::user()->hasPermissionTo('create product'))
                        <div class="col-auto">
                            <span class="create-btn">
                                <a href="#" data-url="{{ route('item.create') }}" data-ajax-popup="true" data-title="{{__('Create New Item')}}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> {{__('Create')}}
                                </a>
                            </span>
                            <span class="create-btn">
                                <a data-uploaditems href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-file-excel"></i> {{__('Import')}}
                                </a>
                            </span>
                            <span>
                                <a href="/item/export" class="btn btn-danger btn-sm">
                                    <i class="fa fa-file-excel"></i> {{__('Export')}}
                                </a>
                            </span>
                            <span>
                                <a data-deleteselecteditems class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> {{__('Delete')}}
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
                                <th>
                                    <div class="btn btn-primary btn-sm">✔</div>
                                </th>
                                <th> {{__('Sku')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Qty')}}</th>
                                <th>{{__('Tax')}}</th>
                                <th>{{__('Purchase Price')}}</th>
                                <th>{{__('Sale Price')}}</th>
                                <th>{{__('Category')}}</th>
                                <th>{{__('Unit')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Description')}}</th>
                                @if(\Auth::user()->type=='company' || \Auth::user()->hasPermissionTo('edit product'))
                                <th class="text-right">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($items as $item)

                            <tr data-id="<?= $item->id ?>" class="font-style">
                                <td></td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->name}}</td>
                                <td>{{ $item->quantity}}</td>
                                <td>
                                    @php
                                    $taxes=\Utility::tax($item->tax);
                                    @endphp

                                    @foreach($taxes as $tax)
                                    {{ !empty($tax)?$tax->name:''  }}<br>

                                    @endforeach
                                </td>
                                <td>{{ \Auth::user()->priceFormat($item->purchase_price )}}</td>
                                <td>{{ \Auth::user()->priceFormat($item->sale_price) }}</td>
                                <td>{{ !empty($item->categories)?$item->categories->name:'' }}</td>
                                <td>{{ !empty($item->units)?$item->units->name:'' }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->description }}</td>
                                @if(\Auth::user()->type=='company' || \Auth::user()->hasPermissionTo('edit product'))
                                <td class="action text-right">
                                    <a href="#" data-url="{{ route('item.edit',$item->id) }}" data-ajax-popup="true" data-title="{{__('Edit Item')}}" class="table-action" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-{{$item->id}}').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['item.destroy', $item->id],'id'=>'delete-form-'.$item->id]) !!}
                                    {!! Form::close() !!}
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection