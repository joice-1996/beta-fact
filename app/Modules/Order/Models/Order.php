<?php

namespace App\Modules\Order\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Order extends Model
{
    protected $collection="orders";

    public function shops()
    {
        return $this->belongsTo('App\Modules\Order\Models\Shop','shop_id','_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','user_id','_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Modules\Order\Models\OrderDetails','order_id','_id');
    }
}
