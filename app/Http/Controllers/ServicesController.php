<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => \App\Http\Resources\Service::collection(Service::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\Illuminate\Http\Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required',
            'description'=> 'required',
            'address'=> 'required',
            'city'=> 'required',
            'state'=> 'required',
            'zip_code'=> 'required',
            'lat'=> ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'long'=> ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);

        $service = Service::create($request->all());

        return response()->json([
            'message' => 'Service has been added',
            'data' => new \App\Http\Resources\Service($service)
        ]);
    }


}
