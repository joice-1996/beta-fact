<?php

namespace App\Modules\Order\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class OrderDetails extends Model
{
    protected $collection="order_details";

    public function products()
    {
        return $this->belongsTo('App\Modules\Product\Models\Product','product_id','_id');
    }
}
