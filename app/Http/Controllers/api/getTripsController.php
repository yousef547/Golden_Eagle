<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\governorate;
use Illuminate\Http\Request;

class getTripsController extends Controller
{
    public function getTrips(){
        $trips = governorate::get();
        return response()->json($trips);
    }
}
