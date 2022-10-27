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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admins.update', $admin->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter First name"
                                    value="{{ $admin->first_name }}">
                            </div>
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last name"
                                    value="{{ $admin->last_name }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                    placeholder="Enter Email" value="{{ $admin->email }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Phone number</label>
                                <input type="tel" name="mobile" class="form-control" placeholder="Enter Phone number"
                                    value="{{ $admin->mobile }}">
                            </div>
                            <div class="mb-4">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    @foreach (\App\Models\User::STATUS as $status)
                                        <option value="{{ $status }}"
                                        {{ (old('status') ? old('status') : $admin->status ?? '') == $status ? 'selected' : '' }}>
                                            @if ($status == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Roles</label>
                                {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'multiple']) !!}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
