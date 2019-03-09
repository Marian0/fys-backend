<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'title',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'lat',
        'long',
    ];


}
