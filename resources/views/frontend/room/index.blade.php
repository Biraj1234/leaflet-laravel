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
                    @foreach ($rooms as $key => $room)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $room->title }}</td>
                            <td>{{ $room->address }}</td>
                            <td>{{ $room->latitude . ',' . $room->longitude }}</td>
                            <td>

                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-primary btn-sm ml-2"><i
                                        class="fas fa-pen"></i></a>
                                <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-info btn-sm ml-2"><i
                                        class="fas fa-eye"></i></a>


                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#exampleModal">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>

                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-dismiss="modal">Close</button>

                                                <form action="{{ route('rooms.destroy', $room->id) }}" method="post">
                                                    <button class="btn btn-danger btn-sm mr-1" type="submit">Yes</button>
                                                    @method('delete')
                                                    @csrf
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        //Map Initialization
        var lists = L.map("lists").setView([27.7007347740801, 85.32650587915138], 13);
        var googleStreets = L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        });
        googleStreets.addTo(lists);
        // Add the markers and popups
        for (var i = 0; i < roomMarkers.length; i++) {
            var markerss = L.marker([roomMarkers[i].latitude, roomMarkers[i].longitude]).addTo(lists);
            let id = roomMarkers[i].id;

            markerss.bindPopup("<b>" + "<a href='{{ route('rooms.show', ':id') }}'>" + roomMarkers[i].title +
                "</a>" +
                "</b><br>" + roomMarkers[i]
                .address);
        }
    </script>
@endsection
