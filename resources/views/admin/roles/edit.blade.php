@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Edit Role Info</h4>
                </div>
                <div class="card-body pt-0">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form method="POST" action="{{route('roles.update',$role->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="form-group">
                                <label>Role name</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="Enter First name" value="{{$role->name}}">
                            </div>
                            <div class="form-group">
                                <label>Permission</label>
                                <br/>
                                @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
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
