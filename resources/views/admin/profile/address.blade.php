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
                    <form method="POST" action="{{url('address/update',$address->id)}}">
                        @csrf
                        {{ method_field('put') }}
                        <div class="">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control"
                                       placeholder="Enter First name" value="{{$address->address}}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
