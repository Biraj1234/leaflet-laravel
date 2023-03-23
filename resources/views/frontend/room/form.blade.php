@extends('layouts.master')

@section('content')
    <div class="card m-4">
        <div class="card-header d-flex justify-content-between">
            <span>Room</span>
            <a href="{{ route('rooms.index') }}" class="btn btn-success btn-sm"><i class="fas fa-list-ul"></i> List</a>
        </div>

        <div class="card-body">
            <form action="{{ isset($item) ? route('rooms.update', $item->id) : route('rooms.store') }}" method="POST">
                @if (isset($item))
                    @method('PUT')
                @endif
                @csrf
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" value="{{ $item->title ?? '' }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="address" value="{{ $item->address ?? '' }}">
                    </div>
                </div>

                {{-- Map --}}
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Map</label>
                    <div class="col-sm-10">
                        <div id="map"></div>
                    </div>
                </div>

                {{-- Latitude --}}
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Latitude</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="lat" value="{{ $item->latitude ?? '' }}"
                            name="latitude" readonly>
                    </div>
                </div>

                {{-- Longitude --}}
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Longitude</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="long" name="longitude"
                            value="{{ $item->longitude ?? '' }}" readonly>
                    </div>
                </div>

                <div class="col-sm-10">
                    <button class="btn btn-success btn-sm"><i class="far fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        //Map Initialization
        var map = L.map("map").setView([0, 0], 13);
        var currentMarker = null;
        var item = '{!! $item ?? '' !!}';
        var testMarker = null;
        //OSM layer
        var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        });
        osm.addTo(map);




        // Get the current location using the Geolocation API
        if (!item) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Create a marker with the current location and add it to the map
                    testMarker = L.marker([position.coords.latitude, position.coords.longitude]);
                    $("#lat").val(position.coords.latitude);
                    $("#long").val(position.coords.longitude);
                    testMarker.addTo(map);
                    // Set the view of the map to the current location
                    map.setView([position.coords.latitude, position.coords.longitude], 16);
                });
            }
        } else {
            let oldMarker = JSON.parse(item);
            map.setView([oldMarker.latitude, oldMarker.longitude], 16);
            testMarker = L.marker([oldMarker.latitude, oldMarker.longitude]);
            testMarker.addTo(map);
        }



        var googleStreets = L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        });

        googleStreets.addTo(map);

        L.Control.geocoder().addTo(map);

        // Marker
        var myIcon = L.icon({
            iconUrl: "red_marker.png",
            iconSize: [40, 40],
        });

        map.on("click", function(e) {
            let lat = e.latlng.lat;
            let long = e.latlng.lng;
            $("#lat").val(lat);
            $("#long").val(long);
            $("#latlong").val(lat + "," + long);

            map.removeLayer(testMarker);
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }
            currentMarker = L.marker(e.latlng);
            currentMarker.addTo(map);
        });
    </script>
@endsection
