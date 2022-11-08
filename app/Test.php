<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Test extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'tests';
    protected $primaryKey = '_id';
    protected $fillable = [
        'name',
    ];
}
