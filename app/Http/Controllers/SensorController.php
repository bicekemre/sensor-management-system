<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::all();

        $data = [];
        foreach ($sensors as $sensor) {
            $data[] = [
                'id' => $sensor->id,
                'name' => $sensor->name,
                'uuid' => $sensor->uuid,
                'room_number' => $sensor->room_number,
                'status' => $sensor->status,
                'last_refill' => $sensor->last_refill,
            ];
        }

        return view('sensors.index', compact('data'));
    }


    public function getData()
    {
        $sensors = Sensor::all();

        $data = [];
        foreach ($sensors as $sensor) {
            $data[] = [
                'id' => $sensor->id,
                'name' => $sensor->name,
                'uuid' => $sensor->uuid,
                'room_number' => $sensor->room_number,
                'status' => $sensor->status,
                'last_refill' => $sensor->last_refill,
            ];
        }

        return response()->json($data);
    }
}
