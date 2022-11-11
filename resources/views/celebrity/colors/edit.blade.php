@extends('celebrity.layouts.master')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css"
          rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>

    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Edit color details</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{route('colors.update',$color->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="row row-sm">
                                <div class="col-lg-6">
                                    <label>Color Name (EN)</label>
                                    <input type="text" name="name_en" class="form-control"
                                        placeholder="Enter Color name english" value="{{$color->getTranslation('name','en')}}">
                                </div>

                                <div class="col-lg-6">
                                    <label>Color Name (AR)</label>
                                    <input type="text" name="name_ar" class="form-control"
                                        placeholder="Enter Color name arabic" value="{{$color->getTranslation('name','ar')}}">
                                </div>

                            </div>
                            <br>
                            <div class="row row-sm">
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <label>Color</label>
                                        <input type="color" name="color" class="form-control colorpicker"
                                            placeholder="Press to display select picker" value="{{$color->color}}">
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
    <script type="text/javascript">
        $('.colorpicker').colorpicker({});
    </script>
@endsection
