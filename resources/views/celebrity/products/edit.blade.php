@extends('celebrity.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

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
                    <form method="POST" action="{{ route('products.update', $product->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Title (EN)</label>
                                    <input type="text" name="title_en" class="form-control" placeholder="title"
                                        value="{{ $product->getTranslation('title', 'en') }}">
                                </div>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <label>Title (AR)</label>
                                    <input type="text" name="title_ar" class="form-control" placeholder="title"
                                        value="{{ $product->getTranslation('title', 'ar') }}">
                                </div>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Description (EN)</label>
                                    <input type="text" name="description_en" class="form-control"
                                        placeholder="description"
                                        value="{{ $product->getTranslation('description', 'en') }}">
                                </div>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <label>Description (AR)</label>
                                    <input type="text" name="description_ar" class="form-control"
                                        placeholder="description"
                                        value="{{ $product->getTranslation('description', 'ar') }}">
                                </div>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>

                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div><input name="price" aria-label="price" class="form-control"
                                                type="number" value="{{ $product->price }}">
                                        </div>
                                    </div>
                                </div>
                                @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Offer price</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div><input name="offer_price" placeholder="offer price"aria-label="price"
                                                class="form-control" type="number" value="{{ $product->offer_price }}">
                                        </div>
                                    </div>
                                </div>
                                @error('offer_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>

                            <br>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label for="category_id">Main Category</label>
                                    <select class="form-control" id="sub_category_name" required>
                                        @foreach ($categories as $id => $category)
                                            <option value="{{ $category->id }}"
                                                {{ (old($r) ? old($r) : $category->id ?? '') == $r ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <label for="category_id">Sub Category</label>
                                    <select class="form-control" name="category_id[]" placeholder="Select Sub Category"
                                        id="sub_category" required multiple>
                                        @foreach ($product->category as $id => $entry)
                                            <option value="{{ $entry->id }}" selected="selected">{{ $entry->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>

                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label for="category_id">Material</label>
                                    @if (count($materials))
                                        <select class="form-control" id="sub_category_name" name="material_id[]" multiple
                                            required>
                                            @foreach ($materials as $material)
                                                <option value="{{ $material->id }}"
                                                    @foreach ($product->material as $p) @if ($material->id == $p->id)selected="selected"@endif @endforeach>
                                                    {{ $material->name }}</option>
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
                                </div>
                                @error('material_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <label for="">Sizes</label>
                                    @if (count($sizes))
                                        <select class="form-control" name="size_id[]" multiple required>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    @foreach ($product->size as $p) @if ($size->id == $p->id)selected="selected"@endif @endforeach>
                                                    {{ $size->name }}</option>
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
                                </div>
                                @error('size_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <br>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Cover images</label>

                                        <div class="input-group file-browser">
                                            <input type="text" class="form-control browse-file" placeholder="choose"
                                                readonly>
                                            <label class="input-group-btn">
                                                <span class="btn btn-default">
                                                    upload <input type="file" name="cover" accept="image/*"
                                                        style="display: none;">
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            @foreach (\App\Models\User::STATUS as $status)
                                                <option value="{{ $status }}"
                                                    {{ (old('status') ? old('status') : $product->status ?? '') == $status ? 'selected' : '' }}>
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
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
