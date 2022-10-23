@extends('celebrity.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-12 col-xl-10 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Create New product</h4>
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
                    <form method="POST" action="{{route('products.update',$product->id)}}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="form-group">
                                <label>title</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="title" value="{{$product->title}}">
                            </div>
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>description</label>
                                <input type="text" name="description" class="form-control"
                                       placeholder="description" value="{{$product->description}}">
                            </div>
                            @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>status</label>
                                <input type="text" name="status" class="form-control"
                                       placeholder="status" value="{{$product->status}}">
                            </div>
                            @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <label for="category_id">Main Category</label>
                            <select class="form-control" id="sub_category_name" required>
                                {{--                                <option value="0">Select a Category</option>--}}
                                @foreach ($categories as $id => $category)
                                    <option
                                        value="{{ $category->id }}" {{ (old($r) ? old($r) : $category->id ?? '') == $r ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                                @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </select>
                            <br>
                            <label for="category_id">Sub Category</label>
                            <select class="form-control" name="category_id[]" placeholder="Select Sub Category"
                                    id="sub_category" required multiple>
                                @foreach($product->category as $id => $entry)
                                    <option
                                        value="{{ $entry->id }}"
                                        selected="selected">{{ $entry->name }}</option>
                                @endforeach
                                @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </select>
                            <br>

                            <label for="category_id">Material</label>
                            @if(count($materials))
                                <select class="form-control" id="sub_category_name" name="material_id[]" multiple
                                        required>
                                    @foreach($materials as $material)
                                        <option value="{{$material->id}}"
                                                @foreach($product->material as $p) @if($material->id == $p->id)selected="selected"@endif @endforeach>{{$material->name}}</option>
                                    @endforeach
                                    @error('material_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </select>
                            @else
                                <p>No materials.. please insert new material
                                    <a class="btn btn-primary-gradient" style="padding: 3px;"
                                       href="{{ route('materials.create') }}"> Create New
                                        Material</a>
                                </p>
                            @endif
                            <br>

                            <label for="">Sizes</label>
                            @if(count($sizes))
                                <select class="form-control" name="size_id[]" multiple required>
                                    @foreach($sizes as $size)
                                        <option value="{{$size->id}}"
                                                @foreach($product->size as $p) @if($size->id == $p->id)selected="selected"@endif @endforeach>{{$size->name}}</option>
                                    @endforeach
                                    @error('size_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </select>
                            @else
                                <p>No sizes.. please insert new size
                                    <a class="btn btn-primary-gradient" style="padding: 3px;"
                                       href="{{ route('sizes.create') }}"> Create New
                                        Material</a>
                                </p>
                            @endif

                            <br>
                            <label for="">Colors with images</label>
                            <div class="form-group">
                                @foreach($colorssd as $color)

                                    <div class="p-2 border mb-1">
                                        <div style="display: inline-flex; width: 800px;">
                                            {{$loop->iteration}}-
                                            <div class="col-sm-2">
                                                <label class="ch">
                                                    <input type="checkbox"
                                                           name="product_colors[{{$color->id}}][color]"
                                                           value="{{$color->id}}"
                                                           @foreach($product->color_product as $p)
                                                               @if($color->id == $p->color_id) checked="checked" @endif
                                                        @endforeach>
                                                    <span>{{$color->name}}</span>
                                                </label>
                                            </div>


                                            <label>quantity:&nbsp;&nbsp;</label>
                                            <input class="form-control form-control-sm mg-b-10" style="width: 200px;"
                                                   type=number name="product_colors[{{$color->id}}][quantity]"
                                                   @foreach($product->color_product as $p)
                                                       @if($color->id == $p->color_id)
                                                           value="{{$p->quantity}}"
                                                @endif
                                                @endforeach
                                            >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <label>image:&nbsp;&nbsp;</label>
                                            <input class="form-control form-control-sm" id="formFileSm"
                                                   type="file" name="product_colors[{{$color->id}}][logo]"
                                                   accept="image/*"
                                                   @foreach($product->color_product as $p)
                                                       @if($color->id == $p->color_id)
                                                           value="{{$p->logo}}"
                                                @endif
                                                @endforeach>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                            <div class="form-group">
                                <label>price</label>
                                <input type="text" name="price" class="form-control"
                                       placeholder="price" value="{{$product->price}}">
                            </div>
                            @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>offer price</label>
                                <input type="text" name="offer_price" class="form-control"
                                       placeholder="offer price" value="{{$product->offer_price}}">
                            </div>
                            @error('offer_price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>slider images</label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="file" name="slider_images[]" data-height="200" multiple/>
                                </div>
                            </div>
                            @error('slider_images')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>cover image</label>
                                <div class="col-sm-12 col-md-4">
                                    <input type="file" value="{{$product->cover}}" name="cover" data-height="200"/>
                                </div>
                            </div>
                            @error('cover')
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

