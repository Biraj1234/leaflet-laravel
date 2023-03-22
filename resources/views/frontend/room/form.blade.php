@extends('layouts.master')

@section('content')
    <div class="card m-4">
        <div class="card-header d-flex justify-content-between">
            <span>Room</span>
            <a href="{{ route('rooms.index') }}" class="btn btn-success btn-sm"><i class="fas fa-list-ul"></i> List</a>
        </div>

        <div class="card-body">
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="address">
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
                        <input type="text" class="form-control" id="lat" name="latitude" readonly>
                    </div>
                </div>

                {{-- Longitude --}}
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Longitude</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="long" name="longitude" readonly>
                    </div>
                </div>

                <div class="col-sm-10">
                    <button class="btn btn-success btn-sm">Save</button>
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
        var testMarker = null;
        //OSM layer
        var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        });
        osm.addTo(map);

        // Get the current location using the Geolocation API
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
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        var googleStreets = L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        });

        googleStreets.addTo(map);

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
