@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Create New ad</h4>
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
                    <form method="POST" action="{{route('ads.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Ad name</label>
                                    <input type="text" name="name" class="form-control"
                                           placeholder="Enter ad name">
                                </div>
                                
                                <div class="col-lg-6">
                                    <label>Ad status</label>
                                <select name="status" class="form-control">
                                    @foreach(\App\Models\User::STATUS as $status)
                                        <option
                                            value="{{$status}}" {{ old('status') == $status ? 'selected' : '' }}>
                                        @if ($status == 1)
                                            Active      
                                        @else
                                            Inactive
                                        @endif
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                                
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Images</label>
                                <div class="input-group file-browser">
                                    <input type="text" class="form-control browse-file" placeholder="choose"
                                        readonly>
                                    <label class="input-group-btn">
                                        <span class="btn btn-default">
                                            upload <input type="file" name="image" accept="image/*"
                                                style="display: none;">
                                        </span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
