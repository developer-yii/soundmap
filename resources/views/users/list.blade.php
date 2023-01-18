@extends('layouts.dashboard')

@section('content')

@php
$lable = "User";
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
                        <button type="button" class="btn btn-danger mb-2 me-2 add-new-button" data-bs-toggle="modal" data-bs-target="#add-modal"><i class="dripicons-user-group me-1"></i> Add New {{$lable}}</button>
                    </div>
                </div>
              
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="userTable" class="table table-centered table-rounded dt-responsive nowrap w-100 mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{$lable}} Name</th>
                                <th>Email Address</th>
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

@section('modal')
<input type="hidden" id="title-label" value="{{$lable}}">
<!-- /.modal -->
<div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class=""><span class="modal-lable-class">Add</span> {{$lable}}</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="modal-body">
                <form id="add-form" method="post" action="{{route('users.add')}}" class="ps-3 pe-3">

                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div id="add_error_message"></div>
                    <div class="mb-3">
                        <label for="name" class="control-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name"> <span class="error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="control-label">Email:</label>
                        <input type="text" class="form-control" id="email" name="email"> <span class="error"></span>
                    </div>
                    <div id="password_group">
                        <div class="mb-3">
                            <label for="password" class="control-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password"> <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="control-label">Confirm Password:</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"> <span class="error"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="user_type" class="control-label">Select User Role:</label>
                        <select class="form-control form-select" id="user_type" name="user_type">
                            <option value="">Select User Role</option>
                            <option value="1">Manager</option>
                            <option value="2">Admin1</option>
                            <option value="3">Admin2</option>
                            
                        </select>
                        <span class="error"></span>
                    </div>       
                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit" id="save_user">Save</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>
    var apiUrl = "{{ route('users.list') }}";
    var addUserUrl = "{{ route('users.add') }}";
    var deleteUrl = "{{ route('users.delete') }}";
    var detailUrl = "{{ route('users.detail') }}";
</script>
@endsection

@section('pagejs')
<script src="{{asset('/')}}page/user.js?{{cacheclear()}}"></script>
@endsection