<?php
/*
|--------------------------------------------------------------------------
| ModuleOne Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the ModuleOne module have to go in here. Make sure
| to change the namespace in case you decide to change the
| namespace/structure of controllers.
|
 */

Route::group(['middleware' =>['web']],function(){

   Route::group(['prefix' =>'order',  'module' =>'order', 'namespace' => 'App\Modules\Order\Controllers'], function () {
   
      Route::get('getOrders','OrderController@index');
      Route::get('getUsers','OrderController@getUsers');
      Route::get('getDistricts','OrderController@getDistricts');
      Route::get('getCategories','OrderController@getCategories');
      Route::get('getShops/{id}','OrderController@getShops');
      Route::get('getProducts/{id}','OrderController@getProducts');
      Route::get('getProductRate/{id}','OrderController@getProductRate');
      Route::post('addTempCart','OrderController@addTempCart');
      Route::get('getOrderCart','OrderController@getOrderCart');
      Route::get('deleteFullCart','OrderController@deleteFullCart');
      Route::get('delete_productFromCart/{id}','OrderController@delete_productFromCart');
      Route::post('saveOrder','OrderController@saveOrder');
      Route::get('delete_Order/{id}','OrderController@delete_Order');
      Route::get('getOrderDetails','OrderController@getOrderDetails');
      Route::get('getOrderDetailss','OrderController@getOrderDetailss');
      Route::get('editViewOrder/{id}','OrderController@editViewOrder');
      Route::get('getUserPerformance','OrderController@getUserPerformance');
      Route::get('getDailyPerformance','OrderController@getDailyPerformance');
     
   });
   

});


