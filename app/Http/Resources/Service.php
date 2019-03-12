<?php

namespace App\Http\Resources;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Resources\Json\JsonResource;

class Service extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $arr = parent::toArray($request);

        $location = [
            'lat' => '',
            'lng' => '',
        ];

        if ($this->resource->location instanceof Point) {
            $location = [
                'lat' => $this->resource->location->getLat(),
                'lng' => $this->resource->location->getLng(),
            ];
        }

        $arr['location'] = $location;

        return $arr;
    }
}
