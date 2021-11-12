<?php

namespace App\Modules\Order\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Shop extends Model
{
    protected $collection = 'shops';

    public function districts()
    {
        return $this->belongsTo('App\Modules\Order\Models\District','district_id','_id');
    }
}
