@extends('admin.layouts.master')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>

    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Edit material details</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{route('materials.update',$materials->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="Enter color name" value="{{$materials->name}}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Colors</label>
                                <select class="form-control" name="colors_id[]" multiple required>
                                    @foreach($colors as $key => $value)
                                        <option value="{{$key}}" @if(in_array($value, $materialColors))selected="selected"@endif>
                                            {{$value}}
                                        </option>
                                    @endforeach
                                    @error('colors_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.colorpicker').colorpicker({});
    </script>
@endsection
