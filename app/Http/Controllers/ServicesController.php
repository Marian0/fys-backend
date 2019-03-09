<?php

namespace App\Http\Controllers;

use App\Models\Service;

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

}
