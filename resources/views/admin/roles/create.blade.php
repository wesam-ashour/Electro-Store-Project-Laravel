@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Create New User</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{route('roles.store')}}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label>Role name</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="Enter First name">
                            </div>
                            <div class="form-group">
                                <label>Permission</label>
                                <br/>
                                @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
