@extends('celebrity.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-12 col-xl-10 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Create New product color</h4>
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
                    <form method="POST" action="{{route('store_color_product',$product)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <div class="form-group">
                               
                                <div class="form-group">
                                    <div class="mb-4">
                                        <label>Color</label>
                                        <select name="color_id" class="form-control">
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}">
                                                    {{$color->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @error('color_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>quantity</label>
                                <input type="number" name="quantity" class="form-control"
                                       placeholder="quantity">
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
