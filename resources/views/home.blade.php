@extends('layouts.app')

@section('content')
    <div class="test" id="map">
        here will be the map
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.4.slim.js"
        integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

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
