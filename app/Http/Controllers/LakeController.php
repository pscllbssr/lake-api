<?php

namespace App\Http\Controllers;

use App\Lake as Lake;

use Laravel\Lumen\Routing\Controller as BaseController;

class LakeController extends BaseController
{

    public function index(){
        $lakes = Lake::with('latestTemperature')->get();
        return response()->json(['status' => 'ok', 'data' => $lakes]);
    }   
    
    public function show($key)
    {
       $lake = Lake::where('key', $key)->with('temperatures')->get()->first();
       return response()->json(['status' => 'ok', 'data' => $lake]);
    }
    
}
