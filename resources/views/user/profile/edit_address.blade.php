@extends('layouts.master')
@section('content')
<style>
    .cards {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid transparent;
        border-radius: .25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
    }

    .me-21 {
        margin-right: .5rem !important;
    }
</style>
<br>
<br>

<div class="container">
    <div class="main-body">
        <div class="row">
            
            <div class="col-lg-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('update_address', $address->id) }}" method="POST">
                    @csrf
                    {{ method_field('put') }}
                    <div class="card">
                        <div class="card-body"><br>
                            <h2 class="d-flex align-items-center mb-3">{{ __('welcome.Edit_Address_Information') }}</h2><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.area') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="area" value="{{$address->area}}" id="area">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.block_no') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="block_no" value="{{$address->block_no}}" id="block_no">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.street_no') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="street_no" value="{{$address->street_no}}" id="street_no">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.building_type') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="building_type" value="{{$address->building_type}}"
                                        id="building_type">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.house_no') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="house_no" value="{{$address->house_no}}" id="house_no">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.building_no') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="building_no" value="{{$address->building_no}}" id="building_no">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.floor_no') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="floor_no" value="{{$address->floor_no}}" id="floor_no">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.flat_no') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="flat_no" value="{{$address->flat_no}}" id="flat_no">
                                </div>
                            </div><br>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ __('welcome.landmark') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="landmark" value="{{$address->landmark}}" id="landmark">
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <button type="submit" class="btn btn-success px-4">{{ __('welcome.Save_changess') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
