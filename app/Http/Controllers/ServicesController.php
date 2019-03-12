<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Default center point
        $center = new Point(0,0);

        if ($request->get('lat') && $request->get('lng')) {
            $center = new Point($request->get('lat'), $request->get('lng'));
        }

        //Filter by distance
        $distanceKm = $request->get('distanceKm');

        $query = Service::query();

        if ($distanceKm) {
            $query->distanceSphere('location', $center, $distanceKm * 1000);
        }

        $query->orderBy('created_at', 'desc');

        $services = $query->paginate(20);

        return response()->json([
            'services' => \App\Http\Resources\Service::collection($services)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);

        return response()->json([
            'service' => new \App\Http\Resources\Service($service)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required',
            'description'=> 'required',
            'address'=> 'required',
            'city'=> 'required',
            'state'=> 'required',
            'country'=> 'required',
            'zip_code'=> 'required',
            'location.lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'location.lng'=> ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']

        ]);

        $service = Service::create($validatedData);

        return response()->json([
            'message' => 'Service has been added',
            'service' => new \App\Http\Resources\Service($service)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $service->fill($request->all());

        $service->save();

        return response()->json([
            'message' => 'Service has been updated',
            'service' => new \App\Http\Resources\Service($service)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $service->delete();

        return response()->json([
            'message' => 'Service has been removed',
            'service' => new \App\Http\Resources\Service($service)
        ]);
    }

}
