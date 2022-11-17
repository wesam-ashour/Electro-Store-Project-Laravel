@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Create New SubAdmin</h4>
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
                    <form method="POST" action="{{ route('admins.store') }}">
                        @csrf
                        <div class="">

                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>First name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter First name">
                                </div>
                                
                                <div class="col-lg-6">
                                    <label>Last name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last name">
                                </div>
                                
                            </div>
                            <br>

                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                    placeholder="Enter Email">
                                </div>
                                
                                <div class="col-lg-6">
                                    <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                    placeholder="Password">
                                </div>
                                
                            </div>
                            <br>

                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Phone number</label>
                                <input type="tel" name="mobile" class="form-control" placeholder="Enter Phone number">
                                </div>
                                
                                <div class="col-lg-6">
                                    <label>Status</label>
                                <select name="status" class="form-control">
                                    @foreach (\App\Models\User::STATUS as $status)
                                        <option value="{{ $status }}"
                                            {{ old('status') == $status ? 'selected' : '' }}>
                                            @if ($status == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif</option>
                                    @endforeach
                                </select>
                                </div>
                                
                            </div>
                            <br>

                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Roels</label>
                                {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                                </div>
                                
                                
                            </div>
                            <br>  
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
