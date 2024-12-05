<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StateCityController extends Controller
{
    public function getCities(Request $request)
    {
        $cities = DB::table('cities')->where('state_id', $request->state_id)->get();
        return response()->json($cities);
    }

    public function getstate(Request $request)
    {
        $states = DB::table('states')->where('name', $request->name)->get();
        return response()->json($states);
    }
}
