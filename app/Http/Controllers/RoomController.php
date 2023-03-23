<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $model;

    public function __construct(Room $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $data = [
            'rooms' => $this->model->orderBy('created_at', 'DESC')->get()
        ];
        return view('frontend.room.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.room.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $this->model->create($data);
        return redirect()->route('rooms.index');
    }

    public function show(Room $room)
    {
        $data = [
            'room' => $room
        ];

        return view('frontend.room.show', $data);
    }


    public function edit(Room $room)
    {
        $data = [
            'item' => $room
        ];
        return view('frontend.room.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->except('_token');
        $room->update($data);
        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $data = $this->model->find($id);
        $data->delete();
        return redirect()->route('rooms.index');
    }
}
