@extends('layouts.admin')
@section('page-title')
{{ __('Payment Reciept') }}
@endsection
@push('css-page')
@endpush
@push('script-page')
@endpush
@section('breadcrumb')
<h6 class="h2 d-inline-block mb-0">{{ __('Payment Reciept') }}</h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Payment Reciept') }}</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(array('route' => array('report.payment'),'method'=>'get')) }}
                    <div class="row">
                        <div class="col">
                            <h2 class="h3 mb-0">{{ __('Filter') }}</h2>
                        </div>
                        <div class="col-md-2">
                            {{ Form::label('start_month',__('Start Date')) }}
                            {{ Form::date('start_month',isset($_GET['start_month'])?$_GET['start_month']:'',array('class'=>'form-control')) }}
                        </div>

                        <div class="col-md-2">
                            {{ Form::label('end_month',__('End Date')) }}
                            {{ Form::date('end_month',isset($_GET['end_month'])?$_GET['end_month']:'',array('class'=>'form-control')) }}
                        </div>

                        <div class="col-md-2">
                            {{ Form::label('end_month',__('Payment Method')) }}
                            <select class="form-control custom-select" name="payment_method" id="">
                                <option value="">Payment Method</option>
                                @foreach($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod['id'] }}">
                                        {{ $paymentMethod['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-auto apply-btn">
                            {{ Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm')) }}
                            <a href="{{ route('report.income.expense') }}"
                                class="btn btn-outline-danger btn-sm">{{ __('Reset') }}</a>
                            <a href="#" onclick="saveAsPDF();"
                                class="btn btn-icon icon-left btn-outline-info pdf-btn btn-sm" id="download-buttons">
                                {{ __('Download') }}
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">
                                        {{ __('Receipt Total') }}</h5>
                                    <span
                                        class="h2 font-weight-bold mb-0">{{ $total }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="report-dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Payment Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentReceipts as $paymentReceipt)
                                <tr>
                                    <td>{{ $paymentReceipt->transaction }}</td>
                                    <td>{{ $paymentReceipt->date }}</td>
                                    <td>{{ \App\PaymentMethod::getNameById($paymentReceipt->payment_method) }}
                                    </td>
                                    <td>{{ $paymentReceipt->payment_type }}</td>
                                    <td>{{ $paymentReceipt->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
