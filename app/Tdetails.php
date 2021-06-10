<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tdetails extends Model
{
    //protected $guarded = []; 

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity'],['itemdetail'],['price']);
    }
}
