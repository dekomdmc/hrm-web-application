@extends('layouts.admin')
@section('page-title')
    {{__('Bill')}}
@endsection
@push('css-page')
@endpush
@push('script-page')
@endpush
@section('breadcrumb')
    <h6 class="h2 d-inline-block mb-0">{{__('Bill')}}</h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('Bill')}}</li>
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
                                <h2 class="h3 mb-0">Filter</h2>
                            </div>
                            <div class="col">
                                <label class="form-control-label" for="exampleFormControlSelect1">Status</label>
                                <select class="form-control font-style" required="required" id="owner" name="owner">
                                    <option value="6">All</option>
                                    <option value="6">Draft</option>
                                    <option value="7">Send</option>
                                    <option value="7">Expired</option>
                                    <option value="7">Declined</option>
                                    <option value="7">Accepted</option>
                                </select>
                            </div>
                            <div class="col">
                                <div class="row input-daterange datepicker align-items-center">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-control-label">Issue Date</label>
                                            <input class="form-control" placeholder="Start date" type="text" value="06/18/2018">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-control-label">Expiry Date</label>
                                            <input class="form-control" placeholder="End date" type="text" value="06/22/2018">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="button" data-toggle="modal" data-target="#add_task" class="btn btn-outline-primary btn-sm">
                                    <span class="btn-inner--icon"><i class="fas fa-check"></i></span>
                                    <span class="btn-inner--text">Apply</span>
                                </button>
                            </div>
                            <div class="col-auto">
                                <button type="button" data-toggle="modal" data-target="#add_task" class="btn btn-outline-danger btn-sm">
                                    <span class="btn-inner--icon"><i class="fa fa-user-times"></i></span>
                                    <span class="btn-inner--text">Reset</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h2 class="h3 mb-0">Manage Bill</h2>
                            </div>
                            <div class="col-auto">
                                <span class="create-btn">
                                        <a href="{{ route('bill.create') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-plus"></i>  {{__('Create')}}
                                        </a>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Vendor</th>
                                <th>Total</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Vendor</th>
                                <th>Total</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <tr>
                                <td>BIL001</td>
                                <td>John</td>
                                <td>$100</td>
                                <td>19-12-2020</td>
                                <td>19-12-2020</td>
                                <td>Send</td>
                                <td class="table-actions">
                                    <a href="#!" class="table-action" data-toggle="tooltip" data-original-title="Edit Bill">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Delete Bill">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <a href="#!" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="View Bill">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

