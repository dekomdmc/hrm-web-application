@extends('layouts.admin')
@section('page-title')
    {{__('Invoice Report')}}
@endsection
@push('css-page')
@endpush
@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>

        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };
            html2pdf().set(opt).from(element).save();

        }


        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#report-dataTable').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: filename
                    },
                    {
                        extend: 'pdf',
                        title: filename
                    }, {
                        extend: 'print',
                        title: filename
                    }, {
                        extend: 'csv',
                        title: filename
                    }
                ],
                language: dataTabelLang,
            });
        });


    </script>
@endpush
@section('breadcrumb')
    <h6 class="h2 d-inline-block mb-0">{{__('Invoice Report')}}</h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links">
            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('Invoice Report')}}</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(array('route' => array('report.invoice'),'method'=>'get')) }}
                        <div class="row">
                            <div class="col">
                                <h2 class="h3 mb-0">{{__('Filter')}}</h2>
                            </div>
                            <div class="col-md-2">
                                {{Form::label('start_month',__('Start Date'))}}
                                {{Form::date('start_month',isset($_GET['start_month'])?$_GET['start_month']:'',array('class'=>'form-control', 'type'=>'date'))}}
                            </div>
                            <div class="col-md-2">
                                {{Form::label('end_month',__('End Date'))}}
                                {{Form::date('end_month',isset($_GET['end_month'])?$_GET['end_month']:'',array('class'=>'form-control'))}}
                            </div>
                            <div class="col-md-2">
                                {{Form::label('status',__('Status'))}}
                                <select class="form-control custom-select" name="status">
                                    <option value="">{{__('All')}}</option>
                                    @foreach($status as $k=>$val)
                                        <option value="{{$k}}" {{(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status']==$k)?'selected':''}}> {{$val}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                {{ Form::label('client', __('Client')) }}
                                {{ Form::select('client', $clients,isset($_GET['client'])?$_GET['client']:'', array('class' => 'form-control custom-select')) }}
                            </div>
                            <div class="col-md-2">
                                {{ Form::label('payment_method', __('Payment Method')) }}
                                <select name="payment_method" class="form-control custom-select">
                                    <option>Payment Method</option>
                                    @foreach($paymentMethods as $paymentMethod)
                                        <option value="{{ $paymentMethod['id'] }}">{{ $paymentMethod['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto apply-btn">
                                {{Form::submit(__('Apply'),array('class'=>'btn btn-outline-primary btn-sm'))}}
                                <a href="{{route('report.invoice')}}" class="btn btn-outline-danger btn-sm">{{__('Reset')}}</a>
                                <a href="#" onclick="saveAsPDF();" class="btn btn-icon icon-left btn-outline-info pdf-btn btn-sm" id="download-buttons">
                                    {{__('Download')}}
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <div id="printableArea">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-wrap">
                            <div class="card-body">
                                <input type="hidden" value="{{$filter['status'].' '.__('Status').' '.'Invoice Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange'].' '.__('of').' '.$filter['client']}}" id="filename">
                                <div class="row">
                                    <div class="col">
                                        {{__('Report')}} : <h4>{{__('Invoice Summary')}}</h4>
                                    </div>
                                    @if($filter['client']!= __('All'))
                                        <div class="col">
                                            {{__('Client')}} : <h4>{{$filter['client'] }}</h4>
                                        </div>
                                    @endif
                                    @if($filter['status']!= __('All'))
                                        <div class="col">
                                            {{__('Status')}} : <h4>{{$filter['status'] }}</h4>
                                        </div>
                                    @endif
                                    <div class="col">
                                        {{__('Duration')}} : <h4>{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">{{__('Total Invoice')}}</h5>
                                            <span class="h2 font-weight-bold mb-0">{{\Auth::user()->priceFormat($totalInvoice)}}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">{{__('Total Due')}}</h5>
                                            <span class="h2 font-weight-bold mb-0">{{\Auth::user()->priceFormat($totalDue)}}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">{{__('Total Tax')}}</h5>
                                            <span class="h2 font-weight-bold mb-0">{{\Auth::user()->priceFormat($totalTax)}}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">{{__('Total Discount')}}</h5>
                                            <span class="h2 font-weight-bold mb-0">{{\Auth::user()->priceFormat($totalDiscount)}}</span>
                                        </div>

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
                                <th>#</th>
                                <th>{{__('Client')}}</th>
                                <th>{{__('Issue Date')}}</th>
                                <th>{{__('Send Date')}}</th>
                                <th>{{__('Expiry Date')}}</th>
                                <th>{{__('Sub Total')}}</th>
                                <th>{{__('Total Tax')}}</th>
                                <th>{{__('Discount')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td><a class="btn btn-outline-primary btn-sm" href="{{route('invoice.show',\Crypt::encrypt($invoice->id))}}">{{\Auth::user()->invoiceNumberFormat($invoice->invoice_id)}}</a></td>
                                    <td>{{!empty($invoice->clients)?$invoice->clients->name:''}}</td>
                                    <td>{{\Auth::user()->dateFormat($invoice->issue_date)}}</td>
                                    <td>{{\Auth::user()->dateFormat($invoice->send_date)}}</td>
                                    <td>{{\Auth::user()->dateFormat($invoice->due_date)}}</td>
                                    <td>{{\Auth::user()->priceFormat($invoice->getSubTotal())}}</td>
                                    <td>{{\Auth::user()->priceFormat($invoice->getTotalTax())}}</td>
                                    <td>{{\Auth::user()->priceFormat($invoice->getTotalDiscount())}}</td>
                                    <td>{{\Auth::user()->priceFormat($invoice->getTotal())}}</td>
                                    <td>
                                        @if($invoice->status == 0)
                                            <span class="badge badge-primary">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 1)
                                            <span class="badge badge-info">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 2)
                                            <span class="badge badge-success">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 3)
                                            <span class="badge badge-warning">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @elseif($invoice->status == 4)
                                            <span class="badge badge-danger">{{ __(\App\Invoice::$statues[$invoice->status]) }}</span>
                                        @endif
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
@endsection

