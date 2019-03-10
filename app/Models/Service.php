<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Service extends Model
{
    use SpatialTrait;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'description',
        'address',
        'city',
        'state',
        'location',
        'zip_code'
    ];

    protected $spatialFields = [
        'location',
        'area'
    ];


    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = new Point(Arr::get($value, 'lat'), Arr::get($value, 'lng'));
    }

}
