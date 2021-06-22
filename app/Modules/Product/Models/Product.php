<?php

namespace App\Modules\Product\Models;

use Jenssegers\Mongodb\Eloquent\Model;
class Product extends Model
{
    protected $collection = 'products';
}
