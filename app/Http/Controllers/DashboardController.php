<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\locations;

class DashboardController extends Controller
{
    public function index()
    {
        $locations = locations::all();
        return view('dashboard.index',compact('locations'));
    }

    public function getLocationDetail(Request $request)
    {
        echo $request->id;
        die;
    }
}
