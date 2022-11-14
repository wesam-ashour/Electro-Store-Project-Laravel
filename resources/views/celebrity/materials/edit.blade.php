@extends('celebrity.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Edit material details</h4>
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
                    <form method="POST" action="{{route('materials.update',$materials->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Material Name (EN)</label>
                                    <input type="text" name="name_en" class="form-control"
                                        placeholder="Enter Material name english" value="{{$materials->getTranslation('name','en')}}">
                                </div>

                                <div class="col-lg-6">
                                    <label>Material Name (AR)</label>
                                    <input type="text" name="name_ar" class="form-control"
                                        placeholder="Enter Material name arabic" value="{{$materials->getTranslation('name','ar')}}">
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
