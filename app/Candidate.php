<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Candidate extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'candidates';
    protected $primaryKey = '_id';

    protected $fillable=['name', 'source', 'user_id', 'created_by'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
