<?php

namespace App\Modules\Order\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Modules\Order\Models\District;
use App\Modules\Order\Models\Shop;
use App\Modules\Product\Models\Category;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\Subcategory;
use App\Modules\Order\Models\OrderCart;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderDetails;
use Validator;

class OrderController extends Controller
{
      /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param
    * @Date 22-06-2021
    * @module  Order
    * Description: Order List
    **/
    public function index()
    {
        $orders=Order::where('status','!=',0)->with(array('users'=>function($query){
            $query->select('name','_id');
        }))->with(array('shops'=>function($query){
            $query->select('shop_name','district_id','_id')->with(array('districts'=>function($query){
                $query->select('distrcit_name','_id');
            }));
        }))->get();
        return $orders;
    }
      /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param
    * @Date 21-06-2021
    * @module  Order
    * Description: get User for list in drop down
    **/
    public function getUsers()
    {
     /*    $users=User::where('user_type','!=','super_admin')
                    ->get();  */
                    /* $users = User::raw()->aggregate([
                        ['$match' =>
                            ['user_type' => 'user']
                        ],

                    ]); */

                    $users=User::raw(function($collection){
                       return $collection->aggregate(
                          [ array(
                               '$match'=>array('user_type'=>'user')
                           )]
                          );
                   }) ;
                    return $users;
    }
      /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param
    * @Date 21-06-2021
    * @module  Order
    * Description: to list districts in drop down
    **/
    public function getDistricts()
    {
        //$districts=District::get();
        $districts=District::raw(function($collection){
            return $collection->aggregate([
                array(
                    '$match'=>array('status'=>1)
                )
            ]);
        });
        return $districts;
    }
      /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param
    * @Date 21-06-2021
    * @module  Order
    * Description: to list Categories in drop down
    **/
    public function getCategories()
    {
        //$categories=Category::get();
        $categories=Category::raw(function($collection){
            return $collection->aggregate([
                array(
                    '$match'=>array('status'=>1)
                )
            ]);
        });
        return $categories;
    }
      /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param $id
    * @Date 21-06-2021
    * @module  Order
    * Description: List product based on district id
    **/
    public function getShops($id)
    {
        $shops=Shop::where('district_id',$id)->get();
       /* $cat=$id;
        $shops=Shop::raw(function($collection){

            return $collection->aggregate([
                array(
                    '$match'=>array('district_id'=>$cat)
                )
            ]);
        }); */
        return $shops;
    }
      /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param $id
    * @Date 21-06-2021
    * @module  Order
    * Description: List products based on category_id
    **/
    public function getProducts($id)
    {
        $products=Product::where('category_id',$id)->get();
        /* $products=Product::raw(function($collection){
            return $collection->aggregate([
                array(
                    '$match'=>array('category_id'=>'$id')
                )
            ]);
        }); */
        return $products;
    }
    public function getProductRate($id)
    {
        $rate=Product::where('_id',$id)->first();
        return $rate;
    }
      /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param Request $request
    * @Date 21-06-2021
    * @module  Order
    * Description: Add Product To Cart
    **/
    public function addTempCart(Request $request)
    {
        $input=$request->all();
        $error=Validator::make($input,[
            'category_id'=>'required',
            'product_id'=>'required',
            'rate'=>'required',
            'quantity'=>'required',
            'total_rate'=>'required',
        ]);
        if($error->fails()){
            return "required_error";
        }
        $exist=OrderCart::where('product_id',$input['product_id'])->first();
        if($exist)
        {
            return "exist";
        }
        $query=OrderCart::insert([
            'category_id'=>$input['category_id'],
            'product_id'=>$input['product_id'],
            'rate'=>(float  )$input['rate'],
            'quantity'=>(int)$input['quantity'],
            'total_rate'=>(float)$input['total_rate'],
        ]);
        if($query)
        {
            return "success";
        }
    }
     /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param
    * @Date 21-06-2021
    * @module  Order
    * Description: List Order Cart
    **/
    public function getOrderCart()
    {
        $orders=OrderCart::with(array('products'=>function($query){
            $query->select('product_name','rate','category_id','_id')->
            with(array('categories'=>function($query){
                $query->select('category_name','_id');
            }));
        }))->get();
        return $orders;
    }

     /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param
    * @Date 21-06-2021
    * @module  Order
    * Description: Delete Cart
    **/
    public function deleteFullCart()
    {
        $query=OrderCart::truncate();
        if($query)
        {
            return "success";
        }
    }
     /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param $id
    * @Date 21-06-2021
    * @module  Order
    * Description: Delete Product from Cart
    **/
    public function delete_productFromCart($id)
    {
        $query=OrderCart::where('_id',$id)->delete();
        if($query)
        {
            return "success";
        }
    }
     /**
    Laravel 6.0
    * @package BETAFACT
    * @author Joice Sara Joseph
    * @param Request $request
    * @Date 21-06-2021
    * @module  Order
    * Description: Store Order
    **/
    public function saveOrder(Request $request)
    {
        $input=$request->all();
        //return $input;
        $final_rate=0;
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $date=$date."T".$time;
        /* $latestOrder = Order::orderBy('created','DESC')->first();
        $ ordercode = '#'.str_pad($latestOrder['_id'] + 1, 5, "0", STR_PAD_LEFT);*/
        $orderId=Order::insertGetId([
            //'order_code'=> $ordercode ,
            'user_id'=>$input['user_id'],
            'final_rate'=>0,
            'shop_id'=>$input['shop_id'],
            'created'=>$date,
            'status'=>1
        ]);
        if($orderId)
        {
            $carts=OrderCart::get();
            foreach($carts as $value)
            {
                $final_rate +=$value['total_rate'];
                $query1=OrderDetails::insert([
                    'order_id'=>(string)$orderId,
                    'product_id'=>$value['product_id'],
                    'quantity'=>$value['quantity'],
                    'total_rate'=>$value['total_rate'],
                    'order_date'=>$date,
                    'status'=>1
                ]);
            }
            if($query1)
            {
                $query=Order::where('_id',$orderId)->update([
                    'final_rate'=>$final_rate
                ]);
                if($query)
                {
                    return "success";
                }
            }
        }

    }
    public function delete_Order($id)
    {
        $query=Order::where('_id',$id)->update([
            'status'=>0
        ]);
        if($query)
        {
            return "success";
        }
    }

    public function getOrderDetails()
    {
        $approved=Order::where('status',3)->count();
        $rejected=Order::where('status',4)->count();
        $pending=Order::where('status',5)->count();
        return [
            $approved,$rejected,$pending
                    ];

    }
    public function getOrderDetailss()
    {
        $approved=Order::where('status',3)->count();
        $rejected=Order::where('status',4)->count();
        $pending=Order::where('status',5)->count();
        return [
            $approved,$rejected,$pending
                    ];
    }
    public function editViewOrder($id)
    {
        $orders=Order::where('_id',$id)->with(array('shops'=>function($query){
            $query->select('shop_name','_id');
        }))->with(array('orders'=>function($query){
            $query->select('order_id','product_id','quantity','total_rate','order_date','_id')->
            with(array('products'=>function($query){
                $query->select('product_name','category_id','_id')->with(array('categories'=>
                function($query){
                    $query->select('category_name','_id');
                }));
            }));
        }))->first();
        return $orders;
    }

    public function getUserPerformance()
    {
      
        $data=[];
        $orders=Order::get(array('final_rate','user_id'));
        foreach ($orders as $order) {
            if (isset($data[$order->user_id])) {
                $data[$order->user_id] += $order->final_rate;
            } else {
                $data[$order->user_id] = $order->final_rate;
            }
        }


        uasort($data,function ($a, $b) {   
            if ($a == $b) {        
                return 0;
            }
                return ($a > $b) ? -1 : 1; 
            }
        );

        $full_data_name  = [];
        $full_data_value  = [];
        foreach ($data as $key => $value) {
            $name = User::where('_id', $key)->first(array('name'))->name;
            // $full_data[] = ['name'=>$name, 'value'=>$value];
            $full_data_name[] = $name;
            $full_data_value[] = $value;
        }

        return [
            'names'=> $full_data_name,
            'value'=> $full_data_value
        ];
        
    }
    public function getDailyPerformance()
    {
        // $orders=Order::get(array('final_rate','created'));
        $dates=[];
        $rates=[];
        $days =[1];
        // foreach ($days as $day) {
        for ($i=1; $i < 32; $i++) {
            if (strlen($i) == 1) {
                $i = '0' . $i;
            }
            $day = $i;
                $start = date('Y-m-'.$day);
              $end = date('Y-m-d', strtotime($start. "+1 days"));
            $order_val=Order::whereBetween('created', [$start,$end])->sum('final_rate');
            $dates[]=$day;
            $rates[]= $order_val;
        }

        // foreach($orders as $order)
        // {
        //     $dates[]=date('Y-m-d', strtotime($order['created']. "+1 days"));
        //     $rates[]=$order['final_rate'];
        // }
        return [
            'dates'=>$dates,
            'rates'=>$rates
        ];
    }

    /* public function userPerformance()
    {
        $users=User::where('user_type','!=','super_admin')->get();
        $orders=Order::orderBy('final_rate','desc')->with(array('users'=>function($query){
            $query->select('name','_id');
        }))->with(array('shops'=>function($query){
                $query->select('shop_name','_id');
        }))->get();
        return [$users, $orders];
    } */

}
