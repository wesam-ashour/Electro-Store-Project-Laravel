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

        #map {
            width: 100%;
            height: 400px;
        }
    </style>
    <br>
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-6">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('update_profile', $user->id) }}" method="POST">
                        @csrf
                        {{ method_field('put') }}
                        <div class="card">
                            <div class="card-body"><br>
                                <h2 class="d-flex align-items-center mb-3">{{ __('welcome.Information') }} </h2><br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.First_Name') }} </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="first_name"
                                               value="{{ $user->first_name }}">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.Last_Name') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="last_name"
                                               value="{{ $user->last_name }}">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.Email') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" class="form-control" name="email"
                                               value="{{ $user->email }}">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.Mobile') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="mobile"
                                               value="{{ $user->mobile }}">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.Password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <button type="submit"
                                                class="btn btn-success px-4">{{ __('welcome.Save_Changes') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6">
                    <div class="cards">
                        <div class="card-body"><br>
                            <div class="d-flex flex-column">


                                <h2 class="d-flex align-items-center mb-3">{{ __('welcome.Addresss') }} </h2>

                                <div class="d-flex align-items-center mb-3"><br>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#myModal"
                                                id="buttonDemoAjax"
                                                onclick="javascript:showlocation()">{{ __('welcome.Add_address') }}</button>
                                    </div>

                                </div>
                                <br>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __('welcome.address') }}</th>
                                        <th scope="col">{{ __('welcome.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($addresss as $address)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $address->area }}</td>
                                            <td>
                                                <a class="btn btn-info"
                                                   href="{{ route('edit_address', $address->id) }}">
                                                    {{ __('welcome.Edit') }}</i></a>
                                                <form action="{{ route('destroy_address', $address->id) }}"
                                                      method="post" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        {{ __('welcome.Delete') }}</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $addresss->links() }}
                            </div>


                            <hr class="my-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('add_address') }}" id="form">
            @csrf
            <!-- Modal -->
            <div class="modal" tabindex="-1" role="dialog" id="myModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="modal-header">

                            <h5 class="modal-title">{{ __('welcome.Add_new_address') }}</h5>

                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="Name">{{ __('welcome.area') }}:</label>
                                    <input type="text" class="form-control" name="area" id="area">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Club">{{ __('welcome.block_no') }}:</label>
                                    <input type="text" class="form-control" name="block_no" id="block_no">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="Country">{{ __('welcome.street_no') }}:</label>
                                    <input type="text" class="form-control" name="street_no" id="street_no">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Goal Score">{{ __('welcome.building_type') }}:</label>
                                    <input type="text" class="form-control" name="building_type" id="building_type">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="Goal Score">{{ __('welcome.house_no') }}:</label>
                                    <input type="text" class="form-control" name="house_no" id="house_no">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Goal Score">{{ __('welcome.building_no') }}:</label>
                                    <input type="text" class="form-control" name="building_no" id="building_no">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="Goal Score">{{ __('welcome.floor_no') }}:</label>
                                    <input type="text" class="form-control" name="floor_no" id="floor_no">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Goal Score">{{ __('welcome.flat_no') }}:</label>
                                    <input type="text" class="form-control" name="flat_no" id="flat_no">
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="Goal Score">{{ __('welcome.landmark') }}:</label>
                                    <input type="text" class="form-control" name="landmark" id="landmark">
                                </div>
                            </div>
                            <label for="Goal Score">Insert current location from Map:</label>
                            <div id="map"></div>

                            <input type="hidden" id="default_latitude" name="lat">
                            <input type="hidden" id="default_longitude" name="lng">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('welcome.Close') }}</button>
                            <button class="btn btn-success" id="ajaxSubmit">{{ __('welcome.Save_changess') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async></script>
    <script>
        let map, activeInfoWindow, markers = [];
        var marker;

        /* ----------------------------- Initialize Map ----------------------------- */
        function showlocation() {
            navigator.geolocation.getCurrentPosition(initMap);
        }

        function initMap(position) {

            var lat = parseFloat(position.coords.latitude);
            var lon = parseFloat(position.coords.longitude);
            document.getElementById('default_latitude').value = lat;
            document.getElementById('default_longitude').value = lon;

            var myLatlng = new google.maps.LatLng(lat, lon);
            var mapOptions = {
                zoom: 10,
                center: myLatlng
            }
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            var marker = new google.maps.Marker({
                position: myLatlng,
                draggable: true,
            });

            marker.setMap(map);

            window.initMap = initMap;

            map.addListener("click", function (event) {
                mapClicked(event);
            });

            marker.addListener("dragend", (event) => {
                $("#default_latitude").val(event.latLng.lat());
                $("#default_longitude").val(event.latLng.lng());
            });

        }
    </script>
@endsection
