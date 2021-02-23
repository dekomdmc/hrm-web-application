@extends('layouts.admin')
@section('page-title')
{{__('Permission')}}
@endsection
@push('css-page')
@endpush
@push('script-page')
<script>
</script>
@endpush
@section('breadcrumb')
<h6 class="h2 d-inline-block mb-0">{{__('Permission')}}</h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{__('Permissions')}}</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        
    </div>
</div>
@endsection