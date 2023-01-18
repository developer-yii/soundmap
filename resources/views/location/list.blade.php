@extends('layouts.dashboard')

@section('content')

@php
$lable = "location";
@endphp

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$lable}} List</li>
                </ol>
            </div>
            <h4 class="page-title">{{$lable}} List</h4>
        </div>
    </div>
</div> 


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-xl-4 mb-2">
                    <div class="text-xl-start mt-xl-0 mt-2">
                        <a href="{{route('location.viewlocation')}}" class="btn btn-primary mb-2 me-2">Add New {{$lable}}</a>
                    </div>
                </div>
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="location" class="table table-centered table-rounded dt-responsive nowrap w-100 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Location Name</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var apiUrl = "{{ route('location.list') }}";
    var location_editurl ="{{route('location.edit')}}";
    var deleteUrl = "{{ route('location.delete') }}"; 


</script>
@endsection

@section('pagejs')
<script src="{{asset('/')}}page/locationdetail.js?{{cacheclear()}}"></script>
@endsection