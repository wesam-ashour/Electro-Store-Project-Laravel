@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Update User Info</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{url('profile/update',$user->id)}}">
                        @csrf
                        {{ method_field('put') }}
                        <div class="">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" name="first_name" class="form-control"
                                       placeholder="Enter First name" value="{{$user->first_name}}">
                            </div>
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" name="last_name" class="form-control"
                                       placeholder="Enter Last name" value="{{$user->last_name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                       placeholder="Enter Email" value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                       placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Phone number</label>
                                <input type="tel" name="mobile" class="form-control"
                                       placeholder="Enter Phone number" value="{{$user->mobile}}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
