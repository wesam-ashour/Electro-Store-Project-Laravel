@extends('admin.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Admin Profile</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Edit Profile</span>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <!-- Col -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 main-content-label">Personal Information</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form class="form-horizontal" method="POST" id="form" action="{{ route('update_profile_admin',$admin->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row row-sm">
                            <div class="col-lg-6">
                                <label>First name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="first name"
                                    value="{{ $admin->first_name }}">
                            </div>
                           
                            <div class="col-lg-6">
                                <label>Last name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="last name"
                                    value="{{ $admin->last_name}}">
                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-lg-6">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="email"
                                    value="{{ $admin->email }}">
                            </div>
                           
                            <div class="col-lg-6">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="password">
                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-lg-6">
                                <label>Mobile</label>
                                <input type="text" name="mobile" class="form-control" placeholder="mobile"
                                    value="{{ $admin->mobile }}">
                            </div>
                           
                            
                        </div>
                        <br>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Update Profile</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- row closed -->
    </div>
@endsection
