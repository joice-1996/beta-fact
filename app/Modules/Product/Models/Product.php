<?php

namespace App\Modules\Product\Models;

use Jenssegers\Mongodb\Eloquent\Model;
class Product extends Model
{
    protected $collection = 'products';

    public function categories()
    {
        return $this->belongsTo('App\Modules\Product\Models\Category','category_id','_id');
    }
}
