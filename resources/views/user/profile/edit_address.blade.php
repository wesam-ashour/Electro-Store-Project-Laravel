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
            width: "100%";
            height: 300px;
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
                                <h2 class="d-flex align-items-center mb-3">{{ __('welcome.Edit_Address_Information') }}</h2>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.area') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="area" value="{{$address->area}}"
                                               id="area">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.block_no') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="block_no"
                                               value="{{$address->block_no}}" id="block_no">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.street_no') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="street_no"
                                               value="{{$address->street_no}}" id="street_no">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.building_type') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="building_type"
                                               value="{{$address->building_type}}"
                                               id="building_type">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.house_no') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="house_no"
                                               value="{{$address->house_no}}" id="house_no">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.building_no') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="building_no"
                                               value="{{$address->building_no}}" id="building_no">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.floor_no') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="floor_no"
                                               value="{{$address->floor_no}}" id="floor_no">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.flat_no') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="flat_no"
                                               value="{{$address->flat_no}}" id="flat_no">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('welcome.landmark') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="landmark"
                                               value="{{$address->landmark}}" id="landmark">
                                    </div>
                                </div>



                            <br>


                            <h6 class="mb-0">Insert current location from Map:</h6>
                            <br>

                            <div id="map"></div>


                            <input type="hidden" id="lat" name="lat">
                            <input type="hidden" id="lng" name="lng">
                            <br>

                            <div class="row">
                                <div class="col-sm-9 text-secondary">
                                    <button type="submit"
                                            class="btn btn-success px-4">{{ __('welcome.Save_changess') }}</button>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async></script>
    <script>
        let map, activeInfoWindow, markers = [];

        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: {{ (double)$datas->lat }},
                    lng: {{ (double)$datas->lng }},
                },
                zoom: 10
            });
            map.addListener("click", function (event) {
                mapClicked(event);
            });
            initMarkers();
        }

        /* --------------------------- Initialize Markers --------------------------- */
        function initMarkers() {
            const initialMarkers = {{ Illuminate\Support\Js::from($initialMarkers) }};
            for (let index = 0; index < initialMarkers.length; index++) {
                const markerData = initialMarkers[index];
                const marker = new google.maps.Marker({
                    position: markerData.position,
                    label: markerData.label,
                    draggable: markerData.draggable,
                    map
                });
                markers.push(marker);
                const infowindow = new google.maps.InfoWindow({
                    content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,
                });
                marker.addListener("click", (event) => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map
                    });
                    activeInfoWindow = infowindow;
                    markerClicked(marker, index);
                });
                marker.addListener("dragend", (event) => {
                    markerDragEnd(event, index);
                });
            }
        }

        /* ------------------------- Handle Map Click Event ------------------------- */
        function mapClicked(event) {
            console.log(map);
            console.log(event.latLng.lat(), event.latLng.lng());
        }

        /* ------------------------ Handle Marker Click Event ----------------------- */
        function markerClicked(marker, index) {
            console.log(map);
            console.log(marker.position.lat());
            console.log(marker.position.lng());
        }

        /* ----------------------- Handle Marker DragEnd Event ---------------------- */
        function markerDragEnd(event, index) {
            console.log(map);
            console.log(event.latLng.lat());
            console.log(event.latLng.lng());
            $("#lat").val(event.latLng.lat());
            $("#lng").val(event.latLng.lng());
        }
    </script>
    <script type="text/javascript">
        var map;

        function initMap() {
            var mapLayer = document.getElementById("map-layer");
            var centerCoordinates = new google.maps.LatLng(37.6, -95.665);
            var defaultOptions = {center: centerCoordinates, zoom: 4}
            map = new google.maps.Map(mapLayer, defaultOptions);
        }

        function locate() {
            document.getElementById("btnAction").disabled = true;
            document.getElementById("btnAction").innerHTML = "Processing...";
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var currentLatitude = position.coords.latitude;
                    var currentLongitude = position.coords.longitude;
                    var infoWindowHTML = "Latitude: " + currentLatitude + "<br>Longitude: " + currentLongitude;
                    var infoWindow = new google.maps.InfoWindow({map: map, content: infoWindowHTML});
                    var currentLocation = {lat: currentLatitude, lng: currentLongitude};
                    infoWindow.setPosition(currentLocation);
                    document.getElementById("btnAction").style.display = 'none';
                });
            }
        }
    </script>

@endsection
