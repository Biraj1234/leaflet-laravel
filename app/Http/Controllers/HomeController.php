<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    protected $room;
    public function __construct()
    {
        $this->middleware('auth');
        $this->room = new Room();
    }


    public function index()
    {
        $lat =  27.685136802151803;
        $long = 85.320260542328;

        $rooms = DB::table('rooms')->select('rooms.title', DB::raw("6371 * acos(cos(radians(" . $lat . ")) * cos(radians(rooms.latitude)) *cos(radians(rooms.longitude) - radians(" . $long . ")) + sin(radians(" . $lat . ")) *sin(radians(rooms.latitude))) as distance"))->orderBy('distance', 'ASC')->get();

        $data = [
            'rooms' => $rooms
        ];

        return view('frontend.home', $data);
    }
}
