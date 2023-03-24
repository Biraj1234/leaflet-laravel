@extends('layouts.master')

@section('content')
    @foreach ($rooms as $room)
        <ul>
            <li>{{ $room->title }} is <b>{{ $room->distance }}</b> km far from you. </li>
        </ul>
    @endforeach
@endsection
