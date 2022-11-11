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
                    <form method="POST" id="form" action="{{ route('products.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Title (EN)</label>
                                    <input type="text" name="title_en" class="form-control" placeholder="title">
                                </div>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <label>Title (AR)</label>
                                    <input type="text" name="title_ar" class="form-control" placeholder="title">
                                </div>
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Description (EN)</label>
                                    <input type="text" name="description_en" class="form-control" placeholder="description">
                                </div>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <label>Description (AR)</label>
                                    <input type="text" name="description_ar" class="form-control" placeholder="description">
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
                                                type="number">
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
                                                class="form-control" type="number">
                                        </div>
                                    </div>
                                </div>
                                @error('offer_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <br>
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label for="category_id">Main Category</label>
                                    <select class="form-control" id="sub_category_name" required>
                                        <option value="0">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                <option value="{{ $material->id }}">{{ $material->name }}
                                                </option>
                                            @endforeach
                                            @error('material_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </select>
                                    @else
                                        <p>No materials.. please insert new material
                                            <a class="btn btn-primary-gradient" style="padding: 3px;"
                                                href="{{ route('materials.create') }}"> Create New
                                                Material
                                            </a>
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
                                                <option value="{{ $size->id }}">{{ $size->name }}
                                                </option>
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

                            <label for="">Colors with images</label>
                            {{-- @forelse($colorssd as $color) --}}
                            <div class="row">
                                @foreach ($colorssd as $color)
                                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">

                                                <li class="list-group-item question">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox"
                                                            name="product_colors[{{ $color->id }}][color]"
                                                            value="{{ $color->id }}"
                                                            class="custom-control-input coupon_question"
                                                            id="checkbox-{{ $color->id }}">
                                                        <label for="checkbox-{{ $color->id }}"
                                                            class="custom-control-label mt-1">{{ $color->name }}</label>
                                                    </div>
                                                </li>

                                                <li class="list-group-item answer as{{ $color->id }}">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                quantity:
                                                            </div><!-- input-group-text -->
                                                        </div><!-- input-group-prepend -->
                                                        <input class="form-control"
                                                            name="product_colors[{{ $color->id }}][quantity]"
                                                            placeholder="0" type="text" id="coupon_field">
                                                    </div>
                                                </li>

                                                <li class="list-group-item answer as{{ $color->id }}">
                                                    <div class="input-group file-browser">
                                                        <input type="text" class="form-control browse-file"
                                                            placeholder="choose" readonly id="coupon_field">
                                                        <label class="input-group-btn">
                                                            <span class="btn btn-default">
                                                                Image <input type="file"
                                                                    name="product_colors[{{ $color->id }}][logo]"
                                                                    accept="image/*" style="display: none;" multiple>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
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
                                @error('cover')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-lg-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        @foreach (\App\Models\User::STATUS as $status)
                                            <option value="{{ $status }}"
                                            >
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
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(".answer").hide();
        $(".image").hide();
        $(".coupon_question").click(function() {
            if ($(this).is(":checked")) {
                $(".as" + $(this).val()).show();
                $(".as" + $(this).val()).show();
            } else {
                $(".as" + $(this).val()).hide(200);
            }
        });
    </script>
@endsection
