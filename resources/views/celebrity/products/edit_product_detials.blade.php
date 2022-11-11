@extends('celebrity.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-7 col-sm-7">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Edit New product</h4>
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
                    <form method="POST" action="{{route('update_details_products',$productsColor[0]->id)}}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="form-group">
                                <label>quantity</label>
                                <input type="number" name="quantity" class="form-control"
                                       placeholder="quantity" value="{{$productsColor[0]->quantity}}">
                            </div>
                            @error('quantity')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>Images</label>

                                <div class="input-group file-browser">
                                    <input type="text" class="form-control browse-file" placeholder="choose" readonly>
                                    <label class="input-group-btn">
                                        <span class="btn btn-default">
                                            upload <input type="file" name="logo" accept="image/*"
                                                style="display: none;">
                                        </span>
                                    </label>
                                </div>
                            </div>
                            @error('logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
            
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

