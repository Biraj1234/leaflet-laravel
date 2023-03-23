@extends('layouts.master')

@section('content')
    <div class="card m-4">
        <div class="card-header d-flex justify-content-between">
            <span>Room</span>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Create</a>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Address</th>
                        <th scope="col">Coordinates</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $room->title }}</td>
                            <td>{{ $room->address }}</td>
                            <td>{{ $room->latitude . ',' . $room->longitude }}</td>
                            <td class="d-flex">
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="post">
                                    <button class="btn btn-danger btn-sm" type="submit"><i
                                            class="fas fa-trash"></i></button>
                                    @method('delete')
                                    @csrf
                                </form>
                                <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-info btn-sm"><i
                                        class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card m-4">
        <div class="card-header">
            Map
        </div>
        <div id="lists" style="height: 50rem"></div>
    </div>
@endsection

@section('script')
    <script>
        let rooms = '{!! $rooms !!}';

        let roomMarkers = JSON.parse(rooms);

        console.log(roomMarkers);

        //Map Initialization
        var lists = L.map("lists").setView([27.7007347740801, 85.32650587915138], 13);

        var googleStreets = L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        });

        googleStreets.addTo(lists);


        var markers = [{
                lat: 51.5,
                lng: -0.1,
                name: "Marker 1",
                info: "This is marker 1",
            },
            {
                lat: 51.51,
                lng: -0.12,
                name: "Marker 2",
                info: "This is marker 2",
            },
            {
                lat: 51.49,
                lng: -0.08,
                name: "Marker 3",
                info: "This is marker 3",
            },
        ];

        console.log(markers);


        // Add the markers and popups
        for (var i = 0; i < roomMarkers.length; i++) {
            var markerss = L.marker([roomMarkers[i].latitude, roomMarkers[i].longitude]).addTo(lists);
            markerss.bindPopup("<b>" + roomMarkers[i].title + "</b><br>" + roomMarkers[i].address);
        }
    </script>
@endsection
