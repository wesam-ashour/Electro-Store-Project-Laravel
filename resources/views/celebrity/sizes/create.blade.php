@extends('celebrity.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Create New Size</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{route('sizes.store')}}">
                        @csrf
                        <div class="">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Size Name (EN)</label>
                                    <input type="text" name="name_en" class="form-control"
                                        placeholder="Enter Size name english">
                                </div>

                                <div class="col-lg-6">
                                    <label>Size Name (AR)</label>
                                    <input type="text" name="name_ar" class="form-control"
                                        placeholder="Enter Size name arabic">
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
