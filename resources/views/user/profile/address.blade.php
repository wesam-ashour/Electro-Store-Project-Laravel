@extends('layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Update User Info</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{url('/user/address/update',$address->id)}}">
                        @csrf
                        {{ method_field('put') }}
                        <div class="">
                            <div class="form-group">
                                <label>area</label>
                                <input type="text" name="area" class="form-control"
                                       placeholder="area" value="{{$address->area}}">
                                <label>block no</label>
                                <input type="text" name="block_no" class="form-control"
                                       placeholder="block no" value="{{$address->block_no}}">
                                <label>building type</label>
                                <input type="text" name="building_type" class="form-control"
                                       placeholder="building type" value="{{$address->building_type}}">
                                <label>street no</label>
                                <input type="text" name="street_no" class="form-control"
                                       placeholder="street no" value="{{$address->street_no}}">
                                <label>house no</label>
                                <input type="text" name="house_no" class="form-control"
                                       placeholder="house no" value="{{$address->house_no}}">
                                <label>building no</label>
                                <input type="text" name="building_no" class="form-control"
                                       placeholder="building no" value="{{$address->building_no}}">
                                <label>floor no</label>
                                <input type="text" name="floor_no" class="form-control"
                                       placeholder="floor no" value="{{$address->floor_no}}">
                                <label>flat no</label>
                                <input type="text" name="flat_no" class="form-control"
                                       placeholder="flat no" value="{{$address->flat_no}}">
                                <label>landmark</label>
                                <input type="text" name="landmark" class="form-control"
                                       placeholder="landmark" value="{{$address->landmark}}">

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
