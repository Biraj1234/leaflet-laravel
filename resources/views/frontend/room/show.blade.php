@extends('layouts.master')

@section('content')
    <div class="card m-4">
        <div class="card-header d-flex justify-content-between">
            <span>Room</span>
            <a href="{{ route('rooms.index') }}" class="btn btn-success btn-sm"><i class="fas fa-list-ul"></i> List</a>
        </div>

        <div class="card-body">
            <div class="row p-1">
                <div class="col border p-4">
                    {{-- Title --}}
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label"><b>Title</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $room->title }}">
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label"><b>Address</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $room->address }}">
                        </div>
                    </div>

                    {{-- Coordinates --}}
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label"><b>Coordinates</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $room->latitude }}, {{ $room->longitude }}">
                        </div>
                    </div>
                </div>
                <div class="col border">
                    <div id="lists" style="height:40rem"></div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        let lat = '{{ $room->latitude }}';
        let long = '{{ $room->longitude }}';
        //Map Initialization
        var lists = L.map("lists").setView([lat, long], 16);
        var googleStreets = L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
            maxZoom: 20,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
        });

        googleStreets.addTo(lists);

        L.marker([lat, long]).addTo(lists);
    </script>
@endsection
